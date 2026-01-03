<?php 

namespace AstraToolbox\Inc\Enums;

use AstraToolbox\Inc\Config\Config;

final class PostMetaEnum 
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    private static function createName(string $name): string
    {
        return Config::PLUGIN_SLUG . $name;
    }

    public static function THEME_STYLE_OVERRIDE_ENABLED(): string
    {
        return self::createName('theme_style_override_enabled');
    }

}