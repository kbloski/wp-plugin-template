<?php 

namespace PluginTemplate\Inc\Application;

use PluginTemplate\Inc\Application\Rest\RestRoutes;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class Application extends AbstractSingleton
{
    public function init()
    {
        RestRoutes::getInstance()->register();
    }
}