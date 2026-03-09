<?php 

namespace PluginTemplate\Inc\Application\Rest\Example;

use PluginTemplate\Inc\Applicaton\DTOs\RouteDto.php
use Throwable;
use WP_REST_Request;

class ExampleRoutes 
{
    public static function register(): void
    {
        return; 
        
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
                
                // new RouteDto(
                //     method: 'GET',
                //     version: 'v1',
                //     path: "/budgets/(?P<id>\d+)/transactions/", 
                //     callback: function(WP_REST_Request $request) 
                //     {
                //         return [
                //             'success' => true
                //         ];
                //         // return GetBudgetMonthlySummariesCallback::handle($request); 
                //     },
                //     permissionCallback: function(WP_REST_Request $request) {
                //         $id = $request->get_param('id');
                //         if ($id < 0) return false;
                //         return BudgetUsersService::getInstance()->canViewBudgetByCurrentUser($id);
                //     },
                //     args: [
                //         // id już jest w path, więc nie trzeba go w args jako required
                //         'amount'  => [
                //             'required' => true,
                //             'type' => 'integer',
                //             'validate_callback' => function($param, $request, $key) {
                //                 return is_float($param) && $param > 0;
                //             }
                //         ],
                //         'type' => [
                //             'required' => true,
                //             'type' => 'string',
                //             'validate_callback' => function($param, $request, $key) {

                //                 // return is_numeric($param) && $param >= 1 && $param <= 12;
                //             }
                //         ],
                //     ]
                // ),


                new RouteDto(
                    method: 'POST',
                    version: 'v1',
                    path: "/budgets/(?P<budgetId>\d+)/transactions/", 
                    callback: function(WP_REST_Request $request) 
                    {
                        return CreateTransactionsCallback::handle($request); 
                    },
                    permissionCallback: function(WP_REST_Request $request) {
                        $id = $request->get_param('budgetId');
                        if ($id < 0) return false;
                        return BudgetUsersService::getInstance()->canViewBudgetByCurrentUser($id);
                    },
                    args: [
                        'amount'  => [
                            'required' => true,
                            'type' => 'float',
                            'validate_callback' => function($param, $request, $key) 
                            {
                                return is_numeric($param) && $param > 0;
                            }
                        ],

                        'type' => [
                            'required' => true,
                            'type' => 'string',
                            'validate_callback' => function($param, $request, $key) {
                                return TransactionTypesEnum::isValid(strtolower($param));
                            }
                        ],

                        'title'  => [
                            'required' => true,
                            'type' => 'string',
                            'validate_callback' => function($param, $request, $key) {
                                return is_string($param) && !empty($param) && strlen($param) <= 128;
                            }
                        ],

                        'description'  => [
                            'required' => false,
                            'type' => 'string',
                            'validate_callback' => function($param, $request, $key) {
                                return is_string($param) && strlen($param) <= 1024;
                            }
                        ],
                    ]
                ),

                new RouteDto(
                    method: 'GET',
                    version: 'v1',
                    path: "/budgets/(?P<budgetId>\d+)/transactions/", 
                    callback: function(WP_REST_Request $request) 
                    {
                        return GetAllBudgetTransactionsCallback::handle($request); 
                    },
                    permissionCallback: function(WP_REST_Request $request) {
                        $id = $request->get_param('budgetId');
                        if ($id < 0) return false;
                        return BudgetUsersService::getInstance()->canViewBudgetByCurrentUser($id);
                    },
                    args: [],
                ),




                // new RouteDto(
                //     method: 'PATCH',
                //     version: 'v1',
                //     path: "/budgets/(?P<id>\d+)",
                //     callback: function(WP_REST_Request $request) { 
                //         return UpdateBudgetCallback::handle($request); 
                //     },
                //     permissionCallback: function(WP_REST_Request $request) {
                //         $id = $request->get_param('id');
                //         if ($id <= 0) return false;

                //         $budgetUser = BudgetUsersRepository::getInstance()->getByBudgetAndUserId($id, get_current_user_id());
                //         if (empty($budgetUser)) return false;

                //         return BudgetPolicy::canUpdate($budgetUser->role);
                //     },
                //     args: [
                //         'id' => [
                //             'required' => true,
                //             'validate_callback' => fn($param) => is_numeric($param) && $param > 0,
                //             'sanitize_callback' => 'absint',
                //         ],
                //         'name' => [
                //             'required' => true,
                //             'sanitize_callback' => 'sanitize_text_field',
                //             'validate_callback' => fn($param) => !empty($param),
                //         ],
                //         'description' => [
                //             'required' => false,
                //             'sanitize_callback' => 'sanitize_text_field',
                //             'validate_callback' => fn($param) => !empty($param),
                //         ],
                //         'currency' => [
                //             'required' => false,
                //             'default' => 'PLN',
                //             'sanitize_callback' => 'sanitize_text_field',
                //             'validate_callback' => fn($param) => is_string($param) && !empty($param),
                //         ],
                //     ]
                // ),

                // new RouteDto(
                //     method: 'POST',
                //     version: 'v1',
                //     path: "/budgets", 
                //     callback: function(WP_REST_Request $request) 
                //     {
                //         return CreateBudgetCallback::handle($request);
                //     },
                //     permissionCallback: function(WP_REST_Request $request) 
                //     {
                //         return is_user_logged_in();
                //     },
                //     args: [
                //         'name' => [
                //             'required' => true,
                //             'sanitize_callback' => 'sanitize_text_field',
                //             'validate_callback' => fn($param) => !empty($param),
                //         ],
                //         'description' => [
                //             'required' => false,
                //             'sanitize_callback' => 'sanitize_text_field',
                //             'validate_callback' => fn($param) => !empty($param),
                //         ],
                //         'currency' => [
                //             'required' => false,
                //             'default' => 'PLN',
                //             'sanitize_callback' => 'sanitize_text_field',
                //             'validate_callback' => fn($param) => is_string($param),
                //         ],
                //     ]
                // ),

                

                // new RouteDto(
                //     method: 'GET',
                //     version: 'v1',
                //     path: "/budgets", 
                //     callback: function(WP_REST_Request $request) 
                //     {
                //         return GetAllCallback::handle($request);
                //     },
                //     permissionCallback: function(WP_REST_Request $request) 
                //     {
                //         return is_user_logged_in();
                //     },
                //     args: [
                        // 'roles' => [
                        //     'required' => false,
                        //     'sanitize_callback' => function ( $param ) {
                        //         if ( ! is_array( $param ) ) {
                        //             return [];
                        //         }

                        //         return array_map( 'sanitize_text_field', $param );
                        //     },
                        //     'validate_callback' => function ( $param ) {
                        //         if ( ! is_array( $param ) ) {
                        //             return false;
                        //         }

                        //         foreach ( $param as $role ) {
                        //             if ( ! is_string( $role ) || empty( $role ) ) {
                        //                 return false;
                        //             }
                        //         }

                        //         return true;
                        //     },
                        // ],

                    // ]
                // ),
            ]; 
        } 
        catch (Throwable $e)
        {
            Logger::error($e);
            throw $e;
        }
    }
}