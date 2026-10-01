<?php

namespace PluginTemplate\Inc\Application\DTOs;

/**
 * Żądanie REST niezależne od hosta.
 */
class ApiRequest
{
    /**
     * @param array<string, mixed> $params Połączone parametry URL, query i body
     */
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $params = [],
    )
    {
    }

    public function getParam(string $name, mixed $default = null): mixed
    {
        return $this->params[$name] ?? $default;
    }
}
