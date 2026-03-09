<?php

namespace PluginTemplate\Inc\Application\DTOs;

use Loyalty\Inc\Core\Configs\PluginConfig;

class RouteDto
{
    public string $namespace;

    /**
     * @param array<string, mixed> $args - konfiguracja argumentów endpointu (WP REST API)
     */
    public function __construct(
        public string $version,
        public string $path,
        public string $method,
        public $callback,
        public $permissionCallback = null,
        public array $args = [], // np. ['id' => ['required' => true, 'validate_callback' => fn($v)=> is_numeric($v)]] 
        // public ?string $requestDtoClass = null,
        // public ?string $responseDtoClass = null
    ) 
    {
        $this->namespace = PluginConfig::NAMESPACE . '/' . $this->version;
    }

    /**
     * Opcjonalna metoda do lokalnego sprawdzania uprawnień (np. testy)
     * @param mixed ...$params
     */
    public function checkPermission(...$params): bool
    {
        return $this->permissionCallback ? ($this->permissionCallback)(...$params) : true;
    }
}
