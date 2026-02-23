<?php

namespace PluginTemplate\Inc\Core\Enums;

use PluginTemplate\Inc\Core\Abstracts\AbstractEnum;
use PluginTemplate\Inc\Core\Configs\PluginConfig;

class PluginCapabilitiesEnum extends AbstractEnum
{
    public static function PLUGIN_ACCESS() : string 
    {
        return PluginConfig::PLUGIN_SLUG.'plugin_access';
    }
}