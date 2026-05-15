<?php 

namespace PluginTemplate\Inc\Infrastructure\Installers;

use PluginTemplate\Inc\Domain\Security\Capabilities;

class CapabilitiesInstaller
{
    public static function activate(): void
    {
        $role = get_role('administrator');

        if ($role) {
            $role->add_cap(Capabilities::CAN_MANAGE);
        }
    }
}