<?php

namespace AstraToolbox\Inc\Core\Enums;

use AstraToolbox\Inc\Core\Abstracts\AbstractEnum;
use AstraToolbox\Inc\Core\Configs\PluginConfig;

class PluginCapabilitiesEnum extends AbstractEnum
{
    public static function PLUGIN_ACCESS() : string 
    {
        return PluginConfig::PLUGIN_SLUG.'plugin_access';
    }
}