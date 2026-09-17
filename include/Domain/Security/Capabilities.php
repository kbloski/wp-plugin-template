<?php 

namespace PluginTemplate\Inc\Domain\Security;

use PluginTemplate\Inc\Core\Configs\PluginConfig;

class Capabilities extends PluginConfig
{
    const ADMIN = self::PLUGIN_SLUG."admin";

    protected function __construct()
    {
        throw new \Exception('Not implemented');
    }
}
