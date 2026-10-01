<?php 

namespace PluginTemplate\Inc\Api\Rest\Example;

use PluginTemplate\Inc\Application\DTOs\ApiRequest;
use PluginTemplate\Inc\Application\Handlers\Example\CreateExampleHandler;
use PluginTemplate\Inc\Application\Handlers\Example\GetExamplesHandler;
use PluginTemplate\Inc\Application\DTOs\RouteDto;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\RestInterface;
use PluginTemplate\Inc\Domain\Interfaces\UsersInterface;
use Throwable;

class ExampleRoutes 
{
    public static function register(): void
    {
        try {
            AppContainer::get()->get(RestInterface::class)->registerRoutes(self::getRoutes());
        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }

    /**
     * Get all example-related routes
     * @return RouteDto[]
    */
    public static function getRoutes() : array 
    {
        try 
        {
            $users = AppContainer::get()->get(UsersInterface::class);

            return [
                new RouteDto(
                    method: 'GET',
                    version: 'v1',
                    path: "/examples", 
                    callback: function(ApiRequest $request) 
                    {
                        return GetExamplesHandler::execute($request);
                    },
                    permissionCallback: function(ApiRequest $request) use ($users) {
                        return $users->isLoggedIn();
                    },
                    args: [],
                ),

                new RouteDto(
                    method: 'POST',
                    version: 'v1',
                    path: "/examples", 
                    callback: function(ApiRequest $request) 
                    {
                        return CreateExampleHandler::execute($request);
                    },
                    permissionCallback: function(ApiRequest $request) use ($users) {
                        return $users->isLoggedIn();
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
