<?php 

namespace PluginTemplate\Inc\Framework;

use PluginTemplate\Inc\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton as AbstractsAbstractSingleton;
use PluginTemplate\Inc\Framework\Loaders\ReactLoader;

class Framework extends AbstractsAbstractSingleton
{
    public function init()
    {
        ReactLoader::getInstance()->init();
    }
}