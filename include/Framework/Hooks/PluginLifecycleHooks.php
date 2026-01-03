<?php

namespace AstraToolbox\Inc\Framework\Hooks;

use AstraToolbox\Inc\Core\Configs\PluginCapabilities;
use LogicException;

final class PluginLifecycleHooks 
{
    private function __construct()
    {
        throw new LogicException('PluginLifecycleHooks cannot be instantiated');
    }

    public static function onActivate(): void
    {
        PluginCapabilities::onAcivatePlugin();
    }

    public static function onDeactivate(): void
    {

    }

    public static function onUninstall(): void
    {
        // Usuwanie tabel, opcji, capabilities
    }
}
