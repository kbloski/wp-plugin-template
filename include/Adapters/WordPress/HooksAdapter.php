<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;

final class HooksAdapter implements HooksInterface
{
    public function addAction(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
        add_action($hook, $callback, $priority, $acceptedArgs);
    }

    public function addFilter(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void
    {
        add_filter($hook, $callback, $priority, $acceptedArgs);
    }

    public function doAction(string $hook, mixed ...$args): void
    {
        do_action($hook, ...$args);
    }

    public function applyFilters(string $hook, mixed $value, mixed ...$args): mixed
    {
        return apply_filters($hook, $value, ...$args);
    }

    public function onActivation(string $pluginFile, callable $callback): void
    {
        register_activation_hook($pluginFile, $callback);
    }

    public function onDeactivation(string $pluginFile, callable $callback): void
    {
        register_deactivation_hook($pluginFile, $callback);
    }
}
