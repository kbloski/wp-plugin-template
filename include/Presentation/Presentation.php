<?php 

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Presentation\Admin\AdminPages;

class Presentation
{
    public function init() : void 
    {
        (new Injectors)->init();        
        (new AdminPages)->init();
        (new Shortcodes)->init();
    }
}