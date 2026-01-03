<?php

namespace AstraToolbox\Inc\Enums;

use AstraToolbox\Inc\Config\Config;

final class PostMetaColorEnum
{
    private function __construct() {}

    private static function createName(string $name): string
    {
        return Config::PLUGIN_SLUG . $name;
    }

    public static function BRAND(): string
    {
        return self::createName('brand');
    }

    public static function ALT_BRAND(): string
    {
        return self::createName('alt_brand');
    }

    public static function HEADING(): string
    {
        return self::createName('heading');
    }

    public static function TEXT(): string
    {
        return self::createName('text');
    }

    public static function PRIMARY(): string
    {
        return self::createName('primary');
    }

    public static function SECONDARY(): string
    {
        return self::createName('secondary');
    }

    public static function BORDER(): string
    {
        return self::createName('border');
    }

    public static function SUBTLE_BACKGROUND(): string
    {
        return self::createName('subtle_background');
    }

    public static function ACCENT(): string
    {
        return self::createName('accent');
    }

    // Custom colors
    public static function FOOTER_BACKGROUND() : string
    {
        return self::createName('footer_background');
    }

    public static function FOOTER_COLOR() : string 
    {
        return self::createName('footer_color');
    }
}
