<?php 

namespace PluginTemplate\Inc\Core\Naming;

use LogicException;
use PluginTemplate\Inc\Core\Configs\PluginConfig;

final class NameBuilder
{
    private function __construct()
    {
        throw new LogicException('Not implemented');
    }

    // dodaje slug
    public static function applySlug(string $string): string
    {
        return PluginConfig::PLUGIN_SLUG . $string;
    }

    // dodaje prefix
    public static function applyPrefix(string $string): string
    {
        return PluginConfig::PLUGIN_PREFIX . $string;
    }

}
