<?php

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\Loaders\ReactDependenciesLoader;

class Loaders extends AbstractSingleton
{
    public function init()
    {
        ReactDependenciesLoader::getInstance();
    }
}