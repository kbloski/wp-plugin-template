<?php 

namespace PluxeeRewards\Inc\Core\Logger;

use PluxeeRewards\Inc\Core\Configs\PluginConfig;
use wpdb;

class Logger
{
    private static ?string $log_file = null;

    private static function get_log_file(): string
    {
        if (self::$log_file === null) {
            $dir = WP_CONTENT_DIR . '/logs';
            if (!is_dir($dir)) {
                wp_mkdir_p($dir);
            }
            self::$log_file = $dir . '/'.PluginConfig::PLUGIN_PREFIX.'logs.log';
        }
        return self::$log_file;
    }

    final public static function log(string $level, string $message, array $context = [], bool $db = false): void
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];

        $class = $caller['class'] ?? '[global]';
        $function = $caller['function'] ?? '[unknown]';
        $file = $caller['file'] ?? '[unknown file]';
        $line = $caller['line'] ?? 0;

        $contextStr = $context ? json_encode($context) : '';
        $contextStr .= " #Context: $class::$function #FILE: $file #LINE: $line";

        $errorMessage = sprintf("[%s] %s %s\n", strtoupper($level), $message ?: '[brak wiadomości]', $contextStr);

        // Log do pliku
        error_log($errorMessage, 3, self::get_log_file());

        // Opcjonalnie log do DB (tylko eventy biznesowe)
        if ($db) {
            global $wpdb;
            $table = $wpdb->prefix . 'pluxee_rewards_events';
            try {
                $wpdb->insert(
                    $table,
                    [
                        'level' => strtoupper($level),
                        'message' => $message,
                        'context' => wp_json_encode($context),
                        'created_at' => current_time('mysql')
                    ],
                    ['%s', '%s', '%s', '%s']
                );
            } catch (\Throwable $e) {
                // fallback do pliku
                error_log("[LOGGER][DB_FAIL] " . $e->getMessage(), 3, self::get_log_file());
            }
        }
    }

    final public static function error(string $message, array $context = [], bool $db = false): void
    {
        self::log('error', $message, $context, $db);
    }

    // final public static function warning(string $message, array $context = [], bool $db = false): void
    // {
    //     self::log('warning', $message, $context, $db);
    // }

    // final public static function info(string $message, array $context = [], bool $db = false): void
    // {
    //     self::log('info', $message, $context, $db);
    // }
}
