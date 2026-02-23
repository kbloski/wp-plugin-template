<?php

namespace PluginTemplate\Inc\Domain\Enums;

use PluginTemplate\Inc\Core\Abstracts\AbstractEnum;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

class TableNamesEnum extends AbstractEnum
{
    private static function createName(string $name): string
    {
        global $wpdb;
        return $wpdb->prefix . NameBuilder::applySlug($name);
    }

    public static function WP_USERS(): string
    {
        global $wpdb;
        return $wpdb->users;
    }

    public static function WP_USERMETA(): string
    {
        global $wpdb;
        return $wpdb->usermeta;
    }

    public static function EXAMPLE(): string 
    {
       return self::createName('example');
    }
}
