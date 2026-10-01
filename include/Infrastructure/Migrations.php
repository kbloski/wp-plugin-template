<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Core\Configs\PluginOptions;
use PluginTemplate\Inc\Core\Configs\PluginOptionsEnum;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;
use PluginTemplate\Inc\Infrastructure\Migrations\_20260522_CreateTables;

class Migrations
{
    private int $migrationsVer;

    public function __construct(private readonly DatabaseInterface $db)
    {
        $this->migrationsVer = PluginOptions::get(
            PluginOptionsEnum::MIGRATIONS_VERSION,
            0
        );
    }

    public function migrateIfNeeded(): void
    {
        if ($this->migrationsVer < 1)
        {
            (new _20260522_CreateTables($this->db))->execute();
            PluginOptions::set(
                PluginOptionsEnum::MIGRATIONS_VERSION,
                1
            );
            $this->migrationsVer = 1;
        }
    }
}
