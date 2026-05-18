<?php 

namespace PluginTemplate\Inc\Core\Container;

use RuntimeException;

class ContainerRegistry
{
    private static ?Container $container = null;

    public static function init(Container $container): void
    {
        self::$container = $container;
    }

    public static function get(): Container
    {
        if (self::$container === null) {
            throw new RuntimeException("Container not initialized.");
        }

        return self::$container;
    }
}