<?php 

namespace PluginTemplate\Inc\Core\Logger;

use PluginTemplate\Inc\Core\Configs\PluginConfig;
use Throwable;
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
        $contextStr .= "$class::$function";

        $timestamp = date('Y-m-d H:i:s');
        $errorMessage = sprintf("\n[%s] \n    [%s] \n    [FILE] %s \n    [LINE] %s \n    [CONTEXT] %s \n    [MESSAGE] %s \n", 
            strtoupper($level), $timestamp, $file, $line, $contextStr, $message ?: '[brak wiadomości]'
        );

        // Log do pliku
        error_log($errorMessage, 3, self::get_log_file());
        error_log($errorMessage);
    }

    final public static function error(string|Throwable $error, bool $db = false, int $traceLimit = 5): void
    {
        if ($error instanceof \Throwable) {
            $traceLines = explode("\n", $error->getTraceAsString());
            $shortTrace = implode("\n", array_slice($traceLines, 0, $traceLimit));

            if (count($traceLines) > $traceLimit) {
                $shortTrace .= "\n... (" . (count($traceLines) - $traceLimit) . " more lines)";
            }

            $errorMessage = sprintf(
                "ERROR DETAILS:\n".
                "Type: %s\n".
                "Message: %s\n".
                "File: %s\n".
                "Line: %d\n".
                "Trace: (top %d lines):\n%s",
                get_class($error),
                $error->getMessage(),
                $error->getFile(),
                $error->getLine(),
                $traceLimit,
                $shortTrace
            );
        } else {
            $errorMessage = $error;
        }

        self::log('error', $errorMessage, [], $db);
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
