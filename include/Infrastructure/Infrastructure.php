<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Infrastructure\Installers\CapabilitiesInstaller;

class Infrastructure
{
    public function init()
    {
        AppContainer::get()->get(Migrations::class)->migrateIfNeeded();
    }

    public function onActivatePlugin() : void
    {
        $container = AppContainer::get();

        $container->get(Migrations::class)->migrateIfNeeded();
        $container->get(CapabilitiesInstaller::class)->install();
    }

    public function onUninstallPlugin() : void 
    {
    }
}
