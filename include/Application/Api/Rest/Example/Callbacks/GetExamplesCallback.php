<?php 

namespace PluginTemplate\Inc\Application\Api\Rest\Example\Callbacks;

use PluginTemplate\Inc\Core\Container\ContainerRegistry;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use PluginTemplate\Inc\Shared\Common\PaginatedResult;
use Throwable;
use WP_Error;
use WP_REST_Response;
use WP_REST_Request;

class GetExamplesCallback 
{
    protected function __construct() {}

    public static function execute(WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        try 
        {   
            $exampleRepo = ContainerRegistry::get()->get(ExampleRepository::class);

            $all = $exampleRepo->getAll();

            return new WP_REST_Response(new PaginatedResult(
                items: $all,
                totalCount: count($all),
                page: 1,
                pageSize: 999999
            ), 200);
        } catch (Throwable $e) 
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
