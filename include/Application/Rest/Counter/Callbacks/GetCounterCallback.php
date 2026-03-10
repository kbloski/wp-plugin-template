<?php 

namespace PluginTemplate\Inc\Application\Rest\Counter\Callbacks;

use PluginTemplate\Inc\Core\Logger\Logger;
use Throwable;
use WP_Error;
use WP_REST_Response;

class GetCounterCallback 
{
    protected function __construct() {}

    public static function handle(\WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        try 
        {   

            return new \WP_REST_Response([
                'counter' => 0
            ], 200);
        } catch (\Throwable $e) 
        {
            Logger::error($e);
            return new \WP_Error(
                'internal_error',
                'An unexpected error occurred',
                ['status' => 500]
            );
        }
    }
}
