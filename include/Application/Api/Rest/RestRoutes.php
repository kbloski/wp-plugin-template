<?php 

namespace PluginTemplate\Inc\Application\Api\Rest;

use PluginTemplate\Inc\Application\Api\Rest\Counter\CounterRoutes;
use PluginTemplate\Inc\Application\Api\Rest\Example\ExampleRoutes;

class RestRoutes
{
    public function register(): void
    {
        ExampleRoutes::register();
    }
}