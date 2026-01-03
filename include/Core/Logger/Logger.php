<?php 

namespace AstraToolbox\Inc\Core\Logger;

class Logger
{
    final public static function error(string $message): void
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];

        $class = $caller['class'] ?? '[global]';
        $function = $caller['function'] ?? '[unknown]';
        $file = $caller['file'] ?? '[unknown file]';
        $line = $caller['line'] ?? 0;

        $context = "$class::$function";

        $errorMessage = $message ?: '[brak wiadomości]';

        error_log($errorMessage . ' #Context: ' . $context . " #FILE: " . $file . " #LINE: " . $line);
    }
}
