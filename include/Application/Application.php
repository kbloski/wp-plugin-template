<?php 

namespace PluginTemplate\Inc\Application;

use PluginTemplate\Inc\Application\Api\Api;

class Application
{
    public function init()
    {
        Api::init();
    }
}