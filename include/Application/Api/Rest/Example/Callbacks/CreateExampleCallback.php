<?php 

namespace PluginTemplate\Inc\Application\Api\Rest\Example\Callbacks;

use PluginTemplate\Inc\Core\Container\ContainerRegistry;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Models\Example;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use Throwable;
use WP_Error;
use WP_REST_Response;
use WP_REST_Request;

class CreateExampleCallback 
{
    protected function __construct() {}

    public static function execute(WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        try 
        {   
            $container = ContainerRegistry::get();
            $exampleRepo = $container->get(ExampleRepository::class);

            $userId = get_current_user_id();
            $message = $request->get_param("message");
            
            $example = new Example(
                id: null,
                userId: $userId,
                message: $message
            );

            $exampleRepo->upsertMany([$example]);            

            return new WP_REST_Response(200);
        } catch (\Throwable $e) 
        {
            Logger::error($e);
            return new WP_Error(
                'internal_error',
                Translations::get("errors.unexpected_error"),
                ['status' => 500]
            );
        }
    }
}
