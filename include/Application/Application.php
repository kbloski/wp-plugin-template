<?php 

namespace PluginTemplate\Inc\Application;

use PluginTemplate\Inc\Api\Api;

class Application
{
    public function init()
    {
        Api::init();
    }
}