<?php 

namespace PluginTemplate\Inc\Framework;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\React\ReactLoader;

class Framework extends AbstractSingleton
{
    public function init()
    {
        ReactLoader::getInstance()->register();
    }
}