<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Core\Configs\PluginOptions;
use PluginTemplate\Inc\Core\Configs\PluginOpitonsEnum;
use PluginTemplate\Inc\Infrastructure\Migrations\_20260522_CreateTables;

class Migrations
{
    private int $migrationsVer;

    public function __construct()
    {
        $this->migrationsVer = PluginOptions::get(
            PluginOpitonsEnum::MIGRATIONS_VERSION,
            0
        );
    }

    public function execute() : void
    {
        if ($this->migrationsVer < 1)
        {
            (new _20260522_CreateTables())->execute();
            PluginOptions::set(
                PluginOpitonsEnum::MIGRATIONS_VERSION,
                1
            );
        }
    }
}