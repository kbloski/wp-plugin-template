<?php 

namespace PluginTemplate\Inc\Application\Api\Rest;

use PluginTemplate\Inc\Application\Api\Rest\Counter\CounterRoutes;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class RestRoutes extends AbstractSingleton
{
    public function register(): void
    {
        CounterRoutes::register();
    }
}