<?php

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\Injectors\ReactAssetsInjector;

class Injectors extends AbstractSingleton
{
    public function init()
    {
        ReactAssetsInjector::getInstance()->register();
    }
}