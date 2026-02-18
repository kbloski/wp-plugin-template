<?php 

namespace PluginTemplate\Inc\Presentation;

use Finance\Inc\Presentation\Loaders\ReactDependenciesLoader;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\Admin\AdminPages;

class Presentation extends AbstractSingleton
{
    public function init() : void 
    {
        Loaders::getInstance()->init();        
        AdminPages::getInstance()->init();
        Shortcodes::getInstance()->init();
    }
}