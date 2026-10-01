<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Domain\Interfaces\AssetsInterface;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;

class StylesInjector
{
    public function __construct(
        private readonly HooksInterface $hooks,
        private readonly AssetsInterface $assets,
    )
    {
    }

    public function register()
    {
        $this->hooks->addAction('wp_enqueue_scripts', function()
        {
            $this->loadGlobal();
        });

        $this->hooks->addAction('admin_enqueue_scripts', function()
        {
            $this->loadGlobal();
        });
    }

    private function loadGlobal()
    {
        $handle = NameBuilder::applyPrefix('global');

        $css_file_url  = PluginPaths::getInstance()->getUrl('assets/Styles/global.css');
        $css_file_path = PluginPaths::getInstance()->getPath('assets/Styles/global.css');

        $this->assets->enqueueStyle(
            $handle,
            $css_file_url,
            [],
            file_exists($css_file_path) ? (string) filemtime($css_file_path) : null
        );
    }
}
