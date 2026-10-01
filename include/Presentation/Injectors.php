<?php

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Presentation\Injectors\ReactAssetsInjector;
use PluginTemplate\Inc\Presentation\Injectors\StylesInjector;
use PluginTemplate\Inc\Presentation\Injectors\VariablesInjector;

class Injectors
{
    public function init()
    {
        $container = AppContainer::get();

        $container->get(ReactAssetsInjector::class)->register();
        $container->get(VariablesInjector::class)->register();
        $container->get(StylesInjector::class)->register();
    }
}
