<?php

namespace PluginTemplate\Inc\Domain\Enums;

use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;

class TableNamesEnum
{
    private static function db(): DatabaseInterface
    {
        return AppContainer::get()->get(DatabaseInterface::class);
    }

    private static function createName(string $name): string
    {
        return self::db()->prefix() . NameBuilder::applySlug($name);
    }

    public static function WP_USERS(): string
    {
        return self::db()->usersTable();
    }

    public static function WP_USERMETA(): string
    {
        return self::db()->usermetaTable();
    }

    public static function EXAMPLE(): string 
    {
       return self::createName('example');
    }
}
