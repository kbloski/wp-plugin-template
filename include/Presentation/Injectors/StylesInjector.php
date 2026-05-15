<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

class StylesInjector
{
    public function register()
    {
        add_action('wp_enqueue_scripts', function()
        {
            $this->loadGlobal();
        });

        add_action('admin_enqueue_scripts', function()
        {
            $this->loadGlobal();
        });
    }

    private function loadGlobal()
    {
        $handle = NameBuilder::applyPrefix('global');

        $css_file_url  = PluginPaths::getInstance()->getUrl('assets/Styles/global.css');
        $css_file_path = PluginPaths::getInstance()->getPath('assets/Styles/global.css');


        wp_register_style(
            $handle,
            $css_file_url,
            [],
            file_exists($css_file_path) ? filemtime($css_file_path) : null
        );

        wp_enqueue_style($handle);
    }
}