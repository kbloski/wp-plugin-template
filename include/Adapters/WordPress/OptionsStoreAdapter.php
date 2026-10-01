<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\OptionsStoreInterface;

final class OptionsStoreAdapter implements OptionsStoreInterface
{
    public function get(string $name, mixed $default = null): mixed
    {
        return get_option($name, $default);
    }

    public function set(string $name, mixed $value): void
    {
        update_option($name, $value);
    }

    public function delete(string $name): void
    {
        delete_option($name);
    }
}
