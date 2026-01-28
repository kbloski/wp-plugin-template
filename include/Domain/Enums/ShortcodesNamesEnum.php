<?php

namespace PluginTemplate\Inc\Domain\Enums;

use PluginTemplate\Inc\Core\Abstracts\AbstractEnum;
use PluginTemplate\Inc\Config\Config;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

final class ShortcodesNamesEnum extends AbstractEnum
{
    public static function ADMIN_SETTINGS(): string
    {
        return NameBuilder::applyPrefix('admin-settings');
    }

    public static function ADMIN_DOCUMENTATION(): string
    {
        return NameBuilder::applyPrefix('admin-documentation');
    }

    public static function ENDPOINTS_DOCS(): string
    {
        return NameBuilder::applyPrefix('endpoints-docs');
    }

    public static function SHORTCODES_DOCS(): string
    {
        return NameBuilder::applyPrefix('shortcodes-docs');
    }

    public static function DEV_TEST(): string
    {
        return NameBuilder::applyPrefix('dev-test');
    }

    public static function HELLO_REACT() : string 
    {
        return NameBuilder::applyPrefix('hello-react');
    }
    
}
