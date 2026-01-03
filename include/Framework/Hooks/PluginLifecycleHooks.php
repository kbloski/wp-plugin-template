<?php

namespace PluginTemplate\Inc\Framework\Hooks;

use PluginTemplate\Inc\Core\Configs\PluginCapabilities;
use LogicException;
use PluginTemplate\Inc\Infrastructure\Infrastructure;

final class PluginLifecycleHooks 
{
    private function __construct()
    {
        throw new LogicException('PluginLifecycleHooks cannot be instantiated');
    }

    public static function onActivate(): void
    {
        PluginCapabilities::onAcivatePlugin();
        Infrastructure::getInstance()->onActivatePlugin();
    }

    public static function onDeactivate(): void
    {

    }

    public static function onUninstall(): void
    {
        // Usuwanie tabel, opcji, capabilities
    }
}
