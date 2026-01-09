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
            $dir = WP_CONTENT_DIR . '/logs/' . PluginConfig::PLUGIN_PREFIX."logs";
            if (!is_dir($dir)) {
                wp_mkdir_p($dir);
            }

            // Nazwa pliku według daty: YYYY-MM-DD.log
            $date = date('Y-m-d'); // np. 2026-01-08
            self::$log_file = $dir . '/' . $date . '.log';
        }

        return self::$log_file;
    }


    final private static function log(string $level, string $message, array $context = [], bool $db = false): void
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];

        $class = $caller['class'] ?? '[global]';
        $function = $caller['function'] ?? '[unknown]';
        $file = $caller['file'] ?? '[unknown file]';
        $line = $caller['line'] ?? 0;

        $contextStr = $context ? json_encode($context) : '';
        $contextStr .= "$class::$function #FILE: $file #LINE: $line";

        $timestamp = date('Y-m-d H:i:s');
        $errorMessage = sprintf("\n[%s] \n    [%s] \n    [CONTEXT] %s \n    [MESSAGE] %s \n", strtoupper($level), $timestamp, $contextStr, $message ?: '[brak wiadomości]');

        // Log do pliku
        error_log($errorMessage, 3, self::get_log_file());
        error_log($errorMessage);
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
