<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Infrastructure\Installers\CapabilitiesInstaller;
use PluginTemplate\Inc\Infrastructure\Tables;

class Infrastructure extends AbstractSingleton
{
    public function init()
    {
        // Tables::dropTables();
        // Tables::createTables();
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