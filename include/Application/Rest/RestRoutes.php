<?php 

namespace PluginTemplate\Inc\Application\Rest;

use PluginTemplate\Inc\Application\Rest\Counter\CounterRoutes;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class RestRoutes extends AbstractSingleton
{
    public function register(): void
    {
        CounterRoutes::register();
    }
}