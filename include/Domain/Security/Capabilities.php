<?php 

namespace PluginTemplate\Inc\Domain\Security;

use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

class Capabilities extends PluginConfig
{
    const CAN_MANAGE = self::PLUGIN_SLUG."can_manage";

    protected function __construct()
    {
        throw new \Exception('Not implemented');
    }
}