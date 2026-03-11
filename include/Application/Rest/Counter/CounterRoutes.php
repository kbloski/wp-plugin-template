<?php 

namespace PluginTemplate\Inc\Application\Rest\Counter;

use PluginTemplate\Inc\Application\DTOs\RouteDto;
use PluginTemplate\Inc\Application\Rest\Counter\Callbacks\GetCounterCallback;
use PluginTemplate\Inc\Application\Rest\Counter\Callbacks\EditCounterCallback;
use PluginTemplate\Inc\Core\Logger\Logger;
use Throwable;
use WP_REST_Request;

class CounterRoutes 
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
                    path: "/counter", 
                    callback: function(WP_REST_Request $request) 
                    {
                        return GetCounterCallback::handle($request);
                    },
                    permissionCallback: function(WP_REST_Request $request) {
                        return is_user_logged_in();
                    },
                    args: [],
                ),

                new RouteDto(
                    method: 'PATCH',
                    version: 'v1',
                    path: "/counter", 
                    callback: function(WP_REST_Request $request) 
                    {
                        return EditCounterCallback::handle($request);
                    },
                    permissionCallback: function(WP_REST_Request $request) {
                        return is_user_logged_in();
                    },
                    args: [
                        'counter' => [
                            'required' => true,
                            'validate_callback' => function($param, $request, $key) {
                                return is_numeric($param);
                            },
                            'sanitize_callback' => 'absint',
                        ],
                    ],
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