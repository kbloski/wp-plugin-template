<?php 

namespace PluginTemplate\Inc\Api;

use PluginTemplate\Inc\Api\Rest\RestRoutes;

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