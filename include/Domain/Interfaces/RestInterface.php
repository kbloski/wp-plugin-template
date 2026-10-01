<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

use PluginTemplate\Inc\Application\DTOs\RouteDto;

/**
 * Port na REST API hosta. Callbacki tras operują na ApiRequest / ApiResponse.
 */
interface RestInterface
{
    /**
     * @param RouteDto[] $routes
     */
    public function registerRoutes(array $routes): void;
}
