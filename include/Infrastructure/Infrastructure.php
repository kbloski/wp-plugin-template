<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Infrastructure\Installers\CapabilitiesInstaller;
use PluginTemplate\Inc\Infrastructure\Tables;

class Infrastructure
{
    public function init()
    {
    }

    public function onActivatePlugin() : void
    {
        CapabilitiesInstaller::activate();
        Tables::createTables();
    }

    public function onUninstallPlugin() : void 
    {
        Tables::dropTables();
    }
}