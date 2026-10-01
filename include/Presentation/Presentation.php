<?php 

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Presentation\Admin\AdminPages;

class Presentation
{
    public function init() : void 
    {
        (new Injectors)->init();        
        AppContainer::get()->get(AdminPages::class)->init();
        Shortcodes::getInstance()->init();
    }
}
