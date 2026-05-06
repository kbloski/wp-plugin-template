<?php 

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Logger\Logger;
use Throwable;

class ReactAssetsInjector extends AbstractSingleton
{
    public function register()
    {
        // Wczytanie podstawowych skryptów WordPress (React/REST)
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });

        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });
    }
}