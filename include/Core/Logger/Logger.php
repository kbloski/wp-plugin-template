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

        $timestamp = date('Y-m-d H:i:s');
        $errorMessage = sprintf("[%s] [%s] %s %s\n", strtoupper($level), $timestamp, $message ?: '[brak wiadomości]', $contextStr);

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
