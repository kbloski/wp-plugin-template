<?php
/**
 * Testy bez WordPressa: php tests/unit.php
 *
 * 1. Skan granicy — poza include/Adapters nie wolno wołać niczego spoza PHP i własnego kodu.
 * 2. Cała wtyczka uruchomiona na atrapach adapterów (bez załadowanego WordPressa).
 */
require __DIR__ . '/../vendor/autoload.php';

use PluginTemplate\Inc\Application\Application;
use PluginTemplate\Inc\Application\DTOs\ApiRequest;
use PluginTemplate\Inc\Application\DTOs\ApiResponse;
use PluginTemplate\Inc\Application\DTOs\RouteDto;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Core;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\DI\AppContainerProvider;
use PluginTemplate\Inc\DI\Container;
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
use PluginTemplate\Inc\Framework\Framework;
use PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks;
use PluginTemplate\Inc\Infrastructure\Infrastructure;
use PluginTemplate\Inc\Presentation\Presentation;
use PluginTemplate\Inc\Shared\Common\PaginatedResult;

$passed = 0;
$failed = [];
function check(bool $condition, string $message): void {
    global $passed, $failed;
    if ($condition) { $passed++; } else { $failed[] = $message; echo "FAIL: $message\n"; }
}
function same(mixed $expected, mixed $actual, string $message): void {
    check($expected === $actual, $message . ' — expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
}
function contains(string $needle, string $haystack, string $message): void {
    check(str_contains($haystack, $needle), $message . ' — ' . var_export($needle, true) . ' not found in ' . var_export($haystack, true));
}

$root = dirname(__DIR__);

// =====================================================================
// 1. Skan granicy
// =====================================================================

/**
 * Zwraca odwołania do świata zewnętrznego w pliku: wywołania funkcji, których nie ma w czystym PHP,
 * global, stałe hosta oraz klasy hosta / bibliotek z vendor.
 *
 * @return string[]
 */
function externalReferences(string $file): array
{
    $tokens = array_values(array_filter(
        token_get_all(file_get_contents($file)),
        fn($t) => !is_array($t) || !in_array($t[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)
    ));

    $notACall = [T_OBJECT_OPERATOR, T_NULLSAFE_OBJECT_OPERATOR, T_DOUBLE_COLON, T_FUNCTION, T_NEW];
    $found = [];

    foreach ($tokens as $i => $token) {
        if (!is_array($token)) {
            continue;
        }

        [$id, $text, $line] = $token;
        $prev = $tokens[$i - 1] ?? null;
        $next = $tokens[$i + 1] ?? null;
        $prevId = is_array($prev) ? $prev[0] : null;

        if ($id === T_GLOBAL) {
            $found[] = "global (line $line)";
            continue;
        }

        if (in_array($id, [T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED], true)) {
            $name = ltrim($text, '\\');
            if (preg_match('/^(WP_|wpdb$|Monolog\\\\|Psr\\\\)/', $name)) {
                $found[] = "$name (line $line)";
            }
            continue;
        }

        if ($id !== T_STRING) {
            continue;
        }

        if (preg_match('/^(WP_|WPINC$|ABSPATH$|wpdb$)/', $text) && !in_array($prevId, [T_OBJECT_OPERATOR, T_DOUBLE_COLON, T_FUNCTION, T_CONST], true)) {
            $found[] = "$text (line $line)";
            continue;
        }

        if ($next === '(' && !in_array($prevId, $notACall, true) && !function_exists($text)) {
            $found[] = "$text() (line $line)";
        }
    }

    return $found;
}

$scanned = 0;
$files = [$root . '/bootstrap.php'];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/include', FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $files[] = $file->getPathname();
    }
}

foreach ($files as $file) {
    $relative = substr($file, strlen($root) + 1);
    if (str_starts_with($relative, 'include/Adapters/')) {
        continue;
    }

    $scanned++;
    same([], externalReferences($file), "$relative stays inside the plugin's own code");
}
check($scanned > 40, "boundary scan covered the codebase ($scanned files)");

// Punkty wejścia znają tylko strażnika defined('ABSPATH') / defined('WP_UNINSTALL_PLUGIN') — resztę robią adaptery.
same([], externalReferences($root . '/index.php'), 'index.php reaches the host only through adapters');
same([], externalReferences($root . '/uninstall.php'), 'uninstall.php reaches the host only through adapters');

// Skaner faktycznie coś łapie.
check(count(externalReferences($root . '/include/Adapters/WordPress/DatabaseAdapter.php')) > 3, 'scanner detects host calls inside an adapter');

// =====================================================================
// 2. Atrapy adapterów
// =====================================================================

$hooks = new class implements HooksInterface {
    public array $actions = [];
    public array $activation = [];
    public array $deactivation = [];
    public function addAction(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void { $this->actions[$hook][] = $callback; }
    public function addFilter(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void { $this->actions[$hook][] = $callback; }
    public function doAction(string $hook, mixed ...$args): void { foreach ($this->actions[$hook] ?? [] as $callback) { $callback(...$args); } }
    public function applyFilters(string $hook, mixed $value, mixed ...$args): mixed { return $value; }
    public function onActivation(string $pluginFile, callable $callback): void { $this->activation[] = $callback; }
    public function onDeactivation(string $pluginFile, callable $callback): void { $this->deactivation[] = $callback; }
    public function fire(string $hook): string { ob_start(); $this->doAction($hook); return ob_get_clean(); }
};

$shortcodes = new class implements ShortcodesInterface {
    public array $registered = [];
    public array $onPage = [];
    public function register(string $name, callable $callback): void { $this->registered[$name] = $callback; }
    public function render(string $name, array $atts = []): string { return isset($this->registered[$name]) ? $this->registered[$name]($atts, null, $name) : ''; }
    public function isUsedOnCurrentPage(string $name): bool { return in_array($name, $this->onPage, true); }
};

$options = new class implements OptionsStoreInterface {
    public array $data = [];
    public function get(string $name, mixed $default = null): mixed { return $this->data[$name] ?? $default; }
    public function set(string $name, mixed $value): void { $this->data[$name] = $value; }
    public function delete(string $name): void { unset($this->data[$name]); }
};

$db = new class implements DatabaseInterface {
    public array $schemas = [];
    public array $rows = [];
    public bool $broken = false;
    public function prefix(): string { return 'test_'; }
    public function usersTable(): string { return 'test_users'; }
    public function usermetaTable(): string { return 'test_usermeta'; }
    public function charsetCollate(): string { return 'DEFAULT CHARSET=utf8mb4'; }
    public function execute(string $sql, array $params = []): int {
        if ($this->broken) { throw new RuntimeException('db is down'); }
        $this->rows[] = ['id' => count($this->rows) + 1, 'user_id' => $params[1], 'message' => $params[2], 'created_at' => '2026-01-01 10:00:00', 'updated_at' => '2026-01-01 10:00:00'];
        return 1;
    }
    public function select(string $sql, array $params = []): array {
        if ($this->broken) { throw new RuntimeException('db is down'); }
        return $this->rows;
    }
    public function lastInsertId(): int { return count($this->rows); }
    public function applySchema(string $sql): void { $this->schemas[] = $sql; }
    public function lastError(): string { return ''; }
    public function clearError(): void {}
    public function beginTransaction(): void {}
    public function commit(): void {}
    public function rollback(): void {}
};

$rest = new class implements RestInterface {
    /** @var RouteDto[] */
    public array $routes = [];
    public function registerRoutes(array $routes): void { $this->routes = array_merge($this->routes, $routes); }
    public function dispatch(string $method, string $path, array $params = []): ?ApiResponse {
        foreach ($this->routes as $route) {
            if ($route->method === $method && $route->namespace . $route->path === $path) {
                $request = new ApiRequest($method, $path, $params);
                return $route->checkPermission($request) ? ($route->callback)($request) : null;
            }
        }
        throw new RuntimeException("No route for $method $path");
    }
};

$assets = new class implements AssetsInterface {
    public array $scripts = [];
    public array $styles = [];
    public function enqueueScript(string $handle, bool $defer = false): void { $this->scripts[$handle] = $defer; }
    public function enqueueStyle(string $handle, string $url, array $deps = [], ?string $version = null): void { $this->styles[$handle] = $url; }
};

$adminMenu = new class implements AdminMenuInterface {
    public array $pages = [];
    public function addPage(string $title, string $capability, string $slug, callable $render, string $iconUrl = '', ?int $position = null): void {
        $this->pages[$slug] = ['parent' => null, 'title' => $title, 'capability' => $capability, 'render' => $render, 'icon' => $iconUrl];
    }
    public function addSubPage(string $parentSlug, string $title, string $capability, string $slug, callable $render): void {
        $this->pages[$slug] = ['parent' => $parentSlug, 'title' => $title, 'capability' => $capability, 'render' => $render];
    }
};

$users = new class implements UsersInterface {
    public int $userId = 0;
    public array $capabilities = [];
    public function currentUserId(): int { return $this->userId; }
    public function isLoggedIn(): bool { return $this->userId > 0; }
    public function grantCapability(string $role, string $capability): void { $this->capabilities[$role][] = $capability; }
};

$translator = new class implements TranslatorInterface {
    public array $textDomains = [];
    public function all(): array { return ['shortcodes' => 'Shortcode\'y', 'errors.unexpected_error' => 'Nieoczekiwany błąd']; }
    public function get(string $key): string { return $this->all()[$key] ?? $key; }
    public function version(): int { return 7; }
    public function loadTextDomain(string $pluginFile): void { $this->textDomains[] = $pluginFile; }
};

$environment = new class($root) implements EnvironmentInterface {
    public function __construct(private string $root) {}
    public function pluginPath(string $pluginFile): string { return dirname($pluginFile) . '/'; }
    public function pluginUrl(string $pluginFile): string { return 'https://example.test/plugins/' . basename(dirname($pluginFile)) . '/'; }
    public function contentPath(string $relativePath = ''): string { return sys_get_temp_dir() . '/' . ltrim($relativePath, '/'); }
    public function ensureDirectory(string $path): bool { return is_dir($path) || mkdir($path, 0777, true); }
};

$escaper = new class implements EscaperInterface {
    public function html(string $text): string { return htmlspecialchars($text, ENT_QUOTES); }
    public function attr(string $text): string { return htmlspecialchars($text, ENT_QUOTES); }
    public function url(string $url): string { return $url; }
    public function json(mixed $data): string { return json_encode($data); }
};

$logger = new class implements LoggerInterface {
    public array $errors = [];
    public function error(string|Throwable $message, array $context = []): void { $this->errors[] = $message instanceof Throwable ? $message->getMessage() : $message; }
};

// =====================================================================
// 3. Wtyczka uruchomiona na atrapach — te same kroki co bootstrap.php i index.php
// =====================================================================

check(!function_exists('add_action') && !defined('ABSPATH'), 'WordPress is not loaded in this test');

$container = new Container();
(new AppContainerProvider())->register($container);

$fakes = [
    HooksInterface::class => $hooks,
    ShortcodesInterface::class => $shortcodes,
    OptionsStoreInterface::class => $options,
    DatabaseInterface::class => $db,
    RestInterface::class => $rest,
    AssetsInterface::class => $assets,
    AdminMenuInterface::class => $adminMenu,
    UsersInterface::class => $users,
    TranslatorInterface::class => $translator,
    EnvironmentInterface::class => $environment,
    EscaperInterface::class => $escaper,
    LoggerInterface::class => $logger,
];
foreach ($fakes as $port => $fake) {
    check($container->has($port), "$port has a default adapter registered");
    $container->set($port, fn() => $fake);
}

AppContainer::init($container);
PluginPaths::getInstance()->init($root . '/index.php');

(new Core())->init();
(new Infrastructure())->init();
(new Application())->init();
(new Presentation())->init();
(new Framework())->init();

$container->get(HooksInterface::class)->onActivation($root . '/index.php', fn() => PluginLifecycleHooks::onActivate());
$container->get(TranslatorInterface::class)->loadTextDomain($root . '/index.php');

// --- Ścieżki ---
same($root . '/assets/x.css', PluginPaths::getInstance()->getPath('/assets/x.css'), 'plugin path comes from the environment port');
same('https://example.test/plugins/' . basename($root) . '/assets/x.css', PluginPaths::getInstance()->getUrl('assets/x.css'), 'plugin url comes from the environment port');

// --- Migracje i opcje ---
same(1, count($db->schemas), 'migration applied the schema once');
contains('CREATE TABLE IF NOT EXISTS test_plugintemplate_example', $db->schemas[0], 'migration uses the prefixed table name');
contains('REFERENCES test_users(ID)', $db->schemas[0], 'migration references the host users table');
contains('DEFAULT CHARSET=utf8mb4', $db->schemas[0], 'migration uses the host charset');
same(['plugintemplate_migration_version' => 1], $options->data, 'migration version stored through the options port');
(new Infrastructure())->init();
same(1, count($db->schemas), 'migration is not repeated');
same('test_plugintemplate_example', TableNamesEnum::EXAMPLE(), 'table name built from the database port');

// --- Aktywacja ---
same(1, count($hooks->activation), 'activation callback registered through the hooks port');
($hooks->activation[0])();
same(['administrator' => [Capabilities::ADMIN]], $users->capabilities, 'activation grants the admin capability through the users port');
same([$root . '/index.php'], $translator->textDomains, 'text domain loaded through the translator port');

// --- Shortcode'y ---
same(9, count($shortcodes->registered), 'all shortcodes registered through the shortcodes port');
$home = $shortcodes->render(ShortcodeNamesEnum::ADMIN_HOME);
contains('<h2>Home</h2>', $home, 'admin home renders');
same(4, substr_count($home, '<div data-react-id='), 'admin home renders its nested shortcodes');
contains('https://example.test/plugins/' . basename($root) . '/assets/React/React.js', $home, 'react module url comes from plugin paths');
$docs = $shortcodes->render(ShortcodeNamesEnum::ADMIN_DOCUMENTATION);
contains("Shortcode'y", $docs, 'documentation uses the translator port');
contains('[' . ShortcodeNamesEnum::EXAMPLE_PANEL . ']', $docs, 'documentation lists public shortcodes');
check(!str_contains($docs, '[' . ShortcodeNamesEnum::ADMIN_HOME . ']'), 'documentation skips private shortcodes');

// --- Menu administracyjne ---
same(['plugintemplate_home', 'plugintemplate_settings', 'plugintemplate_documentation'], array_keys($adminMenu->pages), 'admin pages registered through the admin menu port');
same('plugintemplate_home', $adminMenu->pages['plugintemplate_settings']['parent'], 'settings is a sub page of home');
same(Capabilities::ADMIN, $adminMenu->pages['plugintemplate_home']['capability'], 'admin page requires the plugin capability');
contains('assets/Branding/logo.svg', $adminMenu->pages['plugintemplate_home']['icon'], 'menu entry carries the brand logo');
contains('<h2>Settings</h2>', ($adminMenu->pages['plugintemplate_settings']['render'])(), 'admin page render callback returns html');

// --- Assety ---
$hooks->fire('wp_enqueue_scripts');
same(['wp-data' => true, 'wp-element' => true, 'wp-api-fetch' => true], $assets->scripts, 'frontend enqueues deferred host scripts');
same(['plugintemplate-global'], array_keys($assets->styles), 'frontend enqueues the global stylesheet only');
$assets->scripts = [];
$hooks->fire('admin_enqueue_scripts');
same(['wp-data' => false, 'wp-element' => false, 'wp-api-fetch' => false], $assets->scripts, 'admin enqueues host scripts without defer');
check(isset($assets->styles['plugintemplate-admin-menu-branding']), 'admin enqueues the branding stylesheet');

same('', $hooks->fire('wp_head'), 'no modulepreload when no shortcode is on the page');
$shortcodes->onPage = [ShortcodeNamesEnum::COUNTER];
$head = $hooks->fire('wp_head');
same(2, substr_count($head, 'rel="modulepreload"'), 'modulepreload for React.js and the used component');
contains('Features/Counter/Shortcodes/Counter/Counter.js', $head, 'modulepreload points at the used component');

$footer = $hooks->fire('wp_footer');
contains('window.__plugintemplate = {"config":{"version":', $footer, 'footer injects the config payload');
contains('"translations":{"version":7,', $footer, 'footer payload uses the translator version');
preg_match('/window\.__plugintemplate = (\{.*\}) ;/s', $footer, $m);
same('Nieoczekiwany błąd', json_decode($m[1] ?? '', true)['translations']['data']['errors.unexpected_error'] ?? null, 'footer payload carries translations');

// --- REST ---
same(2, count($rest->routes), 'routes registered through the rest port');
same('plugintemplate/v1', $rest->routes[0]->namespace, 'route namespace');

same(null, $rest->dispatch('GET', 'plugintemplate/v1/examples'), 'anonymous request is rejected by the permission callback');

$users->userId = 42;
$created = $rest->dispatch('POST', 'plugintemplate/v1/examples', ['message' => 'hello']);
check($created instanceof ApiResponse && !$created->isError() && $created->status === 200, 'POST /examples succeeds');
same([42, 'hello'], [$db->rows[0]['user_id'], $db->rows[0]['message']], 'POST /examples stores the row for the current user');

$list = $rest->dispatch('GET', 'plugintemplate/v1/examples');
check($list->data instanceof PaginatedResult, 'GET /examples returns a paginated result');
$json = json_decode(json_encode($list->data), true);
same([1, 1, 'hello', 42], [$json['total_count'], $json['items'][0]['id'], $json['items'][0]['message'], $json['items'][0]['userId']], 'GET /examples returns the stored row');

$db->broken = true;
$error = $rest->dispatch('GET', 'plugintemplate/v1/examples');
same([true, 500, 'internal_error', 'Nieoczekiwany błąd'], [$error->isError(), $error->status, $error->errorCode, $error->errorMessage], 'handler turns a database failure into a translated 500');
check(in_array('db is down', $logger->errors, true), 'failure is logged through the logger port');

// =====================================================================

echo "\n$passed passed, " . count($failed) . " failed\n";
exit($failed ? 1 : 0);
