<?php 

namespace PluginTemplate\Inc\Application\Rest\Example\Callbacks;

use DateTime;
use Throwable;
use WP_Error;
use WP_REST_Response;

class CreateTransactionsCallback 
{
    protected function __construct() {}

    public static function handle(\WP_REST_Request $request): WP_REST_Response|WP_Error
    {
       

            return new WP_REST_Response($result, 201);

        } catch (\Throwable $e) {
            Logger::error($e);
            return new \WP_Error(
                'internal_error',
                'An unexpected error occurred',
                ['status' => 500]
            );
        }
    }
}
