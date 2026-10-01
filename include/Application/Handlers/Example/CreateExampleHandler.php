<?php 

namespace PluginTemplate\Inc\Application\Handlers\Example;

use PluginTemplate\Inc\Application\DTOs\ApiRequest;
use PluginTemplate\Inc\Application\DTOs\ApiResponse;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\UsersInterface;
use PluginTemplate\Inc\Domain\Models\Example;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use Throwable;

class CreateExampleHandler
{
    protected function __construct() {}

    public static function execute(ApiRequest $request): ApiResponse
    {
        try 
        {   
            $container = AppContainer::get();
            $exampleRepo = $container->get(ExampleRepository::class);

            $userId = $container->get(UsersInterface::class)->currentUserId();
            $message = $request->getParam("message");
            
            $example = new Example(
                id: null,
                userId: $userId,
                message: $message
            );

            $exampleRepo->upsertMany([$example]);            

            return new ApiResponse(null, 200);
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
