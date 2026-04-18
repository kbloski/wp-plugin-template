<?php 

namespace PluginTemplate\Inc\Application;

use PluginTemplate\Inc\Application\Api\Api;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class Application extends AbstractSingleton
{
    public function init()
    {
        Api::init();
    }
}