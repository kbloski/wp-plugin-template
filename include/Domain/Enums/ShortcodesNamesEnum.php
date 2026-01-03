<?php

namespace AstraToolbox\Inc\Enums;

use AstraToolbox\Inc\Config\Config;

final class ShortcodesNamesEnum
{
    private function __construct() {}

    private static function createName(string $name): string
    {
        return Config::PLUGIN_PREFIX . $name;
    }

    public static function DEV_TEST(): string
    {
        return self::createName('dev-test');
    }

    public static function ADMIN_DOCUMENTATION(): string
    {
        return self::createName('documentation');
    }

    public static function ADMIN_SETTINGS(): string
    {
        return self::createName('setting');
    }

    public static function ADMIN_SETTINGS_PAGES_STYLES() : string 
    {
        return self::createName('admin-settings-pages-styles');
    }
}
