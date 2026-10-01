<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\AssetsInterface;

final class AssetsAdapter implements AssetsInterface
{
    public function enqueueScript(string $handle, bool $defer = false): void
    {
        wp_enqueue_script($handle);

        if ($defer) {
            // WP 6.3+, no-op na starszych.
            wp_script_add_data($handle, 'strategy', 'defer');
        }
    }

    public function enqueueStyle(string $handle, string $url, array $deps = [], ?string $version = null): void
    {
        wp_enqueue_style($handle, $url, $deps, $version);
    }
}
