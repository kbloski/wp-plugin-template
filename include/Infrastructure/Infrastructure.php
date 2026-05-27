<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Infrastructure\Installers\CapabilitiesInstaller;
use PluginTemplate\Inc\Infrastructure\Tables;

class Infrastructure
{
    public function init()
    {
        (new Migrations())->execute();
    }

    public function onActivatePlugin() : void
    {
        CapabilitiesInstaller::activate();
    }

    public function onUninstallPlugin() : void 
    {
    }
}