<?php 

namespace PluginTemplate\Inc\Application\Handlers\Example;

use PluginTemplate\Inc\Application\DTOs\ApiRequest;
use PluginTemplate\Inc\Application\DTOs\ApiResponse;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use PluginTemplate\Inc\Shared\Common\PaginatedResult;
use Throwable;

class GetExamplesHandler
{
    protected function __construct() {}

    public static function execute(ApiRequest $request): ApiResponse
    {
        try 
        {   
            $exampleRepo = AppContainer::get()->get(ExampleRepository::class);

            $all = $exampleRepo->getAll();

            return new ApiResponse(new PaginatedResult(
                items: $all,
                totalCount: count($all),
                page: 1,
                pageSize: 999999
            ), 200);
        } catch (Throwable $e) 
        {
            Logger::error($e);
            return ApiResponse::error(
                'internal_error',
                Translations::get("errors.unexpected_error"),
                500
            );
        }
    }
}
