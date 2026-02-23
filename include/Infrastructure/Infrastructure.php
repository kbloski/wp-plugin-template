<?php 

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Infrastructure\Tables;

class Infrastructure extends AbstractSingleton
{
    public function init()
    {

    }

    public function onActivatePlugin() : void
    {
        Tables::createTables();
    }

    public function onUninstallPlugin() : void 
    {
        Tables::dropTables();
    }
}