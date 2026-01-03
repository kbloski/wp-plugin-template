<?php

namespace PluginTemplate\Inc\Database;

use PluginTemplate\Inc\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Database\Tables\PageUrlsTable;
use WooLoyalty\Inc\Database\Tables\PageUrlMetaTable;
use WPForms\SmartTags\SmartTag\PageUrl;

class TablesManager 
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function createTables() 
    {
        PageUrlsTable::create();
        PageUrlMetaTable::create();
    }

    public static function dropTables() 
    {
        PageUrlMetaTable::drop();
        PageUrlsTable::drop();
    }
}