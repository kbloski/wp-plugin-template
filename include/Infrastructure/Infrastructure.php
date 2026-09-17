<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Infrastructure\Installers\CapabilitiesInstaller;
use PluginTemplate\Inc\Infrastructure\Tables;

class Infrastructure
{
    public function init()
    {
        (new Migrations())->migrateIfNeeded();
    }

    public function onActivatePlugin() : void
    {
        (new Migrations())->migrateIfNeeded();
        (new CapabilitiesInstaller())->install();
    }

    public function onUninstallPlugin() : void 
    {
    }
}
