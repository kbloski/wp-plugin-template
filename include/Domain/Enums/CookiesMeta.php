<?php

namespace AstraToolbox\Inc\Enums;

use AstraToolbox\Inc\Config\Config;

final class CookiesMeta
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    private static function createName(string $name): string
    {
        return Config::PLUGIN_SLUG . '_' . $name;
    }



    public static function OVERRIDE_THEME_VARIABLES_JSON(): string
    {
        return self::createName('override_theme_variables_json');
    }
}