<?php

namespace PluginTemplate\Inc\Core\Logger;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as MonologLogger;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use Throwable;

class Logger
{
    private static ?MonologLogger $logger = null;

    public static function error(string|Throwable $message, array $context = []): void
    {
        if ($message instanceof Throwable) {
            $context['exception'] = $message;
            $message = $message->getMessage();
        }

        self::getLogger()->error($message, $context);
    }

    private static function getLogger(): MonologLogger
    {
        if (self::$logger === null) {
            self::$logger = new MonologLogger(PluginConfig::PLUGIN_SLUG);
            self::$logger->pushHandler(
                new StreamHandler(self::getLogFile(), Level::Debug)
            );
        }

        return self::$logger;
    }

    private static function getLogFile(): string
    {
        $directory = WP_CONTENT_DIR . '/logs/' . PluginConfig::PLUGIN_PREFIX . 'logs';

        if (!is_dir($directory)) {
            wp_mkdir_p($directory);
        }

        return $directory . '/' . date('Y-m-d') . '.log';
    }
}
