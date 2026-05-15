<?php 

namespace PluginTemplate\Inc\Application\Api;

use PluginTemplate\Inc\Application\Api\Rest\RestRoutes;

class Api 
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function init()
    {
        (new RestRoutes)->register();
    }
}