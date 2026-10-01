<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Application\DTOs\ApiRequest;
use PluginTemplate\Inc\Application\DTOs\ApiResponse;
use PluginTemplate\Inc\Application\DTOs\RouteDto;
use PluginTemplate\Inc\Domain\Interfaces\RestInterface;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

/**
 * Tłumaczy WP REST API na ApiRequest / ApiResponse używane przez handlery.
 */
final class RestAdapter implements RestInterface
{
    public function registerRoutes(array $routes): void
    {
        add_action('rest_api_init', function () use ($routes) {
            foreach ($routes as $route) {
                $this->registerRoute($route);
            }
        });
    }

    private function registerRoute(RouteDto $route): void
    {
        register_rest_route(
            $route->namespace,
            $route->path,
            [
                'methods'             => $route->method,
                'callback'            => fn(WP_REST_Request $request) => $this->toWpResponse(
                    ($route->callback)($this->toApiRequest($request))
                ),
                'permission_callback' => fn(WP_REST_Request $request) => $route->checkPermission(
                    $this->toApiRequest($request)
                ),
                'args'                => $route->args,
            ]
        );
    }

    private function toApiRequest(WP_REST_Request $request): ApiRequest
    {
        return new ApiRequest(
            method: $request->get_method(),
            path: $request->get_route(),
            params: $request->get_params()
        );
    }

    private function toWpResponse(ApiResponse $response): WP_REST_Response|WP_Error
    {
        if ($response->isError()) {
            return new WP_Error(
                $response->errorCode,
                $response->errorMessage,
                ['status' => $response->status]
            );
        }

        return new WP_REST_Response($response->data, $response->status);
    }
}
