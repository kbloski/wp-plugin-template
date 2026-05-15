<?php 

namespace PluginTemplate\Inc\Presentation\Injectors;

class ReactAssetsInjector
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