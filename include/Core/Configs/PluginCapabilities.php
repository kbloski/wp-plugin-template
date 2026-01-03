<?php 

namespace AstraToolbox\Inc\Core\Configs;

use AstraToolbox\Inc\Core\Enums\PluginCapabilitiesEnum;

class PluginCapabilities 
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function onAcivatePlugin()
    {
        $rola = get_role('administrator');
        if ($rola) {
            $rola->add_cap(PluginCapabilitiesEnum::PLUGIN_ACCESS()); 
        }
    }
}