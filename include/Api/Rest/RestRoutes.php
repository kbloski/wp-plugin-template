<?php 

namespace PluginTemplate\Inc\Api\Rest;

use PluginTemplate\Inc\Api\Rest\Example\ExampleRoutes;

class RestRoutes
{
    public function register(): void
    {
        ExampleRoutes::register();
    }
}