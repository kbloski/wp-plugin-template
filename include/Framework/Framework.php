<?php 

namespace PluginTemplate\Inc\Framework;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\React\ReactRootRegistry;

class Framework extends AbstractSingleton
{
    public function init()
    {
        ReactRootRegistry::getInstance()->register();
    }
}