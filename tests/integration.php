<?php
/**
 * Testy na prawdziwych adapterach: php tests/integration.php /ścieżka/do/wp-load.php
 *
 * Wtyczka musi być aktywna. Test dopisuje własne wiersze (prefix "plugintemplate-test:") i je usuwa.
 */
$wpLoad = $argv[1] ?? '';
if (!is_file($wpLoad)) {
    fwrite(STDERR, "Usage: php tests/integration.php /path/to/wp-load.php\n");
    exit(2);
}
require $wpLoad;

use PluginTemplate\Inc\Adapters\Monolog\MonologLoggerAdapter;
use PluginTemplate\Inc\Core\Configs\PluginOptions;
use PluginTemplate\Inc\Core\Configs\PluginOptionsEnum;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;
use PluginTemplate\Inc\Domain\Interfaces\AdminMenuInterface;
use PluginTemplate\Inc\Domain\Interfaces\AssetsInterface;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;
use PluginTemplate\Inc\Domain\Interfaces\EnvironmentInterface;
use PluginTemplate\Inc\Domain\Interfaces\EscaperInterface;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;
use PluginTemplate\Inc\Domain\Interfaces\LoggerInterface;
use PluginTemplate\Inc\Domain\Interfaces\OptionsStoreInterface;
use PluginTemplate\Inc\Domain\Interfaces\RestInterface;
use PluginTemplate\Inc\Domain\Interfaces\ShortcodesInterface;
use PluginTemplate\Inc\Domain\Interfaces\TranslatorInterface;
use PluginTemplate\Inc\Domain\Interfaces\UsersInterface;
use PluginTemplate\Inc\Domain\Security\Capabilities;

$passed = 0;
$failed = [];
function check(bool $condition, string $message): void {
    global $passed, $failed;
    if ($condition) { $passed++; } else { $failed[] = $message; echo "FAIL: $message\n"; }
}
function same(mixed $expected, mixed $actual, string $message): void {
    check($expected === $actual, $message . ' — expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
}

if (!class_exists(AppContainer::class)) {
    fwrite(STDERR, "Plugin is not active.\n");
    exit(2);
}

const TEST_MARKER = 'plugintemplate-test:';
$container = AppContainer::get();
$root = dirname(__DIR__);

// --- Każdy port ma adapter z include/Adapters ---
$ports = [
    HooksInterface::class, ShortcodesInterface::class, OptionsStoreInterface::class, DatabaseInterface::class,
    RestInterface::class, AssetsInterface::class, AdminMenuInterface::class, UsersInterface::class,
    TranslatorInterface::class, EnvironmentInterface::class, EscaperInterface::class, LoggerInterface::class,
];
foreach ($ports as $port) {
    $adapter = $container->get($port);
    check($adapter instanceof $port && str_starts_with($adapter::class, 'PluginTemplate\\Inc\\Adapters\\'), "$port resolves to an adapter");
}
check($container->get(LoggerInterface::class) instanceof MonologLoggerAdapter, 'logger is the Monolog adapter');

// --- Środowisko i ścieżki ---
same(trailingslashit($root), PluginPaths::getInstance()->getPluginPath(), 'plugin path');
same(plugins_url('/', $root . '/index.php'), PluginPaths::getInstance()->getPluginUrl(), 'plugin url');

// --- Opcje i baza ---
same(1, (int) PluginOptions::get(PluginOptionsEnum::MIGRATIONS_VERSION), 'migration version read through the options adapter');
$db = $container->get(DatabaseInterface::class);
same($wpdb->prefix . 'plugintemplate_example', TableNamesEnum::EXAMPLE(), 'example table name');
same($wpdb->users, TableNamesEnum::WP_USERS(), 'users table name');
same([['n' => '3']], $db->select('SELECT %d + %d AS n', [1, 2]), 'select with placeholders');
same(1, count($db->select('SHOW TABLES LIKE %s', [TableNamesEnum::EXAMPLE()])), 'example table exists');
$threw = false;
$wpdb->suppress_errors(true);
try { $db->execute('UPDATE plugintemplate_missing_table SET a = 1'); } catch (RuntimeException) { $threw = true; }
$wpdb->suppress_errors(false);
check($threw, 'failed query throws');
$db->clearError();

// --- Hooki cyklu życia, tłumaczenia ---
check(has_action('activate_' . plugin_basename($root . '/index.php')) !== false, 'activation hook registered');
check(has_action('deactivate_' . plugin_basename($root . '/index.php')) !== false, 'deactivation hook registered');
$translator = $container->get(TranslatorInterface::class);
check(count($translator->all()) >= 7 && $translator->get('missing.key') === 'missing.key', 'translator returns the catalog and falls back to the key');
same(filemtime($root . '/include/Adapters/WordPress/TranslatorAdapter.php'), $translator->version(), 'translator version follows the catalog file');

// --- Shortcode'y ---
foreach ((new ReflectionClass(ShortcodeNamesEnum::class))->getConstants() as $name => $shortcode) {
    if (str_starts_with($shortcode, ShortcodeNamesEnum::PLUGIN_PREFIX) && $shortcode !== ShortcodeNamesEnum::PLUGIN_PREFIX && $name !== 'API_COUNTER') {
        check(shortcode_exists($shortcode), "shortcode [$shortcode] registered in WordPress");
    }
}
$html = do_shortcode('[' . ShortcodeNamesEnum::ADMIN_HOME . ']');
same(4, substr_count($html, '<div data-react-id='), 'admin home renders nested shortcodes through WordPress');
check(str_contains($html, plugins_url('assets/React/React.js', $root . '/index.php')), 'shortcode imports React.js from the plugin url');
check(str_contains(do_shortcode('[' . ShortcodeNamesEnum::ADMIN_DOCUMENTATION . ']'), '[' . ShortcodeNamesEnum::COUNTER . ']'), 'documentation shortcode lists shortcodes');

// --- Assety i wstrzykiwane zmienne ---
// Odpala tylko callbacki tej wtyczki — inne wtyczki nie muszą działać w CLI.
$inject = function (string $hook): string {
    global $wp_filter;
    ob_start();
    foreach ($wp_filter[$hook]->callbacks ?? [] as $callbacks) {
        foreach ($callbacks as $callback) {
            $function = $callback['function'];
            $owner = $function instanceof Closure ? (new ReflectionFunction($function))->getClosureScopeClass()?->getName() : (is_array($function) && is_object($function[0]) ? $function[0]::class : '');
            if (str_starts_with((string) $owner, 'PluginTemplate\\')) {
                $function();
            }
        }
    }
    return ob_get_clean();
};
$inject('wp_enqueue_scripts');
check(wp_script_is('wp-element', 'enqueued') && wp_script_is('wp-api-fetch', 'enqueued') && wp_script_is('wp-data', 'enqueued'), 'host scripts enqueued');
same('defer', wp_scripts()->get_data('wp-element', 'strategy'), 'host scripts deferred');
check(wp_style_is('plugintemplate-global', 'enqueued'), 'global stylesheet enqueued');

$footer = $inject('wp_footer');
check((bool) preg_match('/window\.__plugintemplate = (\{.*\}) ;/s', $footer, $m), 'footer injects the payload');
$payload = json_decode($m[1] ?? '', true);
check(is_array($payload) && $payload['config']['version'] > 0 && isset($payload['translations']['data']['button.increment']), 'payload is valid JSON with config and translations');

// --- Menu administracyjne ---
$adminId = (int) (get_users(['role' => 'administrator', 'number' => 1, 'fields' => 'ID'])[0] ?? 0);
check($adminId > 0, 'an administrator exists');
wp_set_current_user($adminId);
check(current_user_can(Capabilities::ADMIN), 'administrator has the plugin capability');
require_once ABSPATH . 'wp-admin/includes/plugin.php';
$menu = $submenu = [];
$inject('admin_menu');
same(['plugintemplate_home'], array_column($menu, 2), 'top level admin page added');
same(['plugintemplate_home', 'plugintemplate_settings', 'plugintemplate_documentation'], array_column($submenu['plugintemplate_home'] ?? [], 2), 'admin sub pages added');
check(str_ends_with((string) (array_values($menu)[0][6] ?? ''), 'assets/Branding/logo.svg'), 'menu entry carries the brand logo');
ob_start(); do_action('toplevel_page_plugintemplate_home'); $page = ob_get_clean();
check(str_contains($page, '<h2>Home</h2>'), 'admin page renders through the admin menu adapter');

// --- REST ---
$routes = rest_get_server()->get_routes();
check(isset($routes['/plugintemplate/v1/examples']), 'REST route registered');

wp_set_current_user(0);
same(401, rest_do_request(new WP_REST_Request('GET', '/plugintemplate/v1/examples'))->get_status(), 'anonymous request is rejected');

wp_set_current_user($adminId);
$message = TEST_MARKER . uniqid();
try {
    $post = new WP_REST_Request('POST', '/plugintemplate/v1/examples');
    $post->set_header('Content-Type', 'application/json');
    $post->set_body(json_encode(['message' => $message]));
    same(200, rest_do_request($post)->get_status(), 'POST /examples through the REST adapter');

    $response = rest_do_request(new WP_REST_Request('GET', '/plugintemplate/v1/examples'));
    same(200, $response->get_status(), 'GET /examples through the REST adapter');
    $data = json_decode(wp_json_encode(rest_get_server()->response_to_data($response, false)), true);
    $mine = array_values(array_filter($data['items'] ?? [], fn($item) => $item['message'] === $message));
    same(1, count($mine), 'created row is returned');
    same($adminId, (int) ($mine[0]['userId'] ?? 0), 'created row belongs to the current user');
    same(count($data['items']), $data['total_count'] ?? null, 'paginated result is serialized');
} finally {
    $wpdb->query($wpdb->prepare('DELETE FROM ' . TableNamesEnum::EXAMPLE() . ' WHERE message LIKE %s', TEST_MARKER . '%'));
}
same('0', $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM ' . TableNamesEnum::EXAMPLE() . ' WHERE message LIKE %s', TEST_MARKER . '%')), 'test rows cleaned up');

echo "\n$passed passed, " . count($failed) . " failed\n";
exit($failed ? 1 : 0);
