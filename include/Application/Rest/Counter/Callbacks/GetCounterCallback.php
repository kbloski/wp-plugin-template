<?php 

namespace PluginTemplate\Inc\Application\Rest\Counter\Callbacks;

use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\UserMetaEnum;
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
            $counter = (int) get_user_meta(
                user_id: get_current_user_id(), 
                key: UserMetaEnum::COUNTER(),
                single: true 
            ) ?? 0;

            return new \WP_REST_Response([
                'counter' => $counter 
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
