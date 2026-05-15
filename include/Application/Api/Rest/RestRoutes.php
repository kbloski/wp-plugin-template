<?php 

namespace PluginTemplate\Inc\Application\Api\Rest;

use PluginTemplate\Inc\Application\Api\Rest\Counter\CounterRoutes;

class RestRoutes
{
    public function register(): void
    {
        CounterRoutes::register();
    }
}