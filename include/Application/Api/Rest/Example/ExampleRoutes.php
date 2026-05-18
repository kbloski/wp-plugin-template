<?php 

namespace PluginTemplate\Inc\Application\Api\Rest\Example;

use PluginTemplate\Inc\Application\Api\Rest\Counter\Callbacks\GetExamples;
use PluginTemplate\Inc\Application\Api\Rest\Example\Callbacks\CreateExampleCallback;
use PluginTemplate\Inc\Application\Api\Rest\Example\Callbacks\GetExamplesCallback;
use PluginTemplate\Inc\Application\DTOs\RouteDto;
use PluginTemplate\Inc\Core\Logger\Logger;
use Throwable;
use WP_REST_Request;

class ExampleRoutes 
{
    public static function register(): void
    {
        try {
            add_action('rest_api_init', function () {
                $routes = self::getRoutes();
                
                foreach ($routes as $route) {
                    register_rest_route(
                        $route->namespace,
                        $route->path,
                        [
                            'methods'             => $route->method,
                            'callback'            => $route->callback,
                            'permission_callback' => $route->permissionCallback,
                            'args'                => $route->args,
                        ]
                    );
                }
            });

        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }

    /**
     * Get all budget-related routes
     * @return RouteDto[]
    */
    public static function getRoutes() : array 
    {
        try 
        {
            return [
                new RouteDto(
                    method: 'GET',
                    version: 'v1',
                    path: "/examples", 
                    callback: function(WP_REST_Request $request) 
                    {
                        return GetExamplesCallback::execute($request);
                    },
                    permissionCallback: function(WP_REST_Request $request) {
                        return is_user_logged_in();
                    },
                    args: [],
                ),

                new RouteDto(
                    method: 'POST',
                    version: 'v1',
                    path: "/examples", 
                    callback: function(WP_REST_Request $request) 
                    {
                        return CreateExampleCallback::execute($request);
                    },
                    permissionCallback: function(WP_REST_Request $request) {
                        return is_user_logged_in();
                    },
                ),


            ]; 
        } 
        catch (Throwable $e)
        {
            Logger::error($e);
            throw $e;
        }
    }
}