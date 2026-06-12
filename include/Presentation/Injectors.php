<?php

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Presentation\Injectors\ReactAssetsInjector;
use PluginTemplate\Inc\Presentation\Injectors\StylesInjector;
use PluginTemplate\Inc\Presentation\Injectors\VariablesInjector;

class Injectors
{
    public function init()
    {
        (new ReactAssetsInjector)->register();
        (new VariablesInjector())->register();
        (new StylesInjector())->register();
    }
}