<?php

namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Presentation\Injectors\ReactAssetsInjector;
use PluginTemplate\Inc\Presentation\Injectors\StylesInjector;
use PluginTemplate\Inc\Presentation\Injectors\TranslationsInjector;

class Injectors
{
    public function init()
    {
        (new ReactAssetsInjector)->register();
        (new TranslationsInjector())->register();
        (new StylesInjector())->register();
    }
}