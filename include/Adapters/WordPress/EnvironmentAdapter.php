<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\EnvironmentInterface;

final class EnvironmentAdapter implements EnvironmentInterface
{
    public function pluginPath(string $pluginFile): string
    {
        return plugin_dir_path($pluginFile);
    }

    public function pluginUrl(string $pluginFile): string
    {
        return plugin_dir_url($pluginFile);
    }

    public function contentPath(string $relativePath = ''): string
    {
        return WP_CONTENT_DIR . '/' . ltrim($relativePath, '/');
    }

    public function ensureDirectory(string $path): bool
    {
        return wp_mkdir_p($path);
    }
}
