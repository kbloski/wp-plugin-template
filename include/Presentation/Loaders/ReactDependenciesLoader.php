<?php 

namespace PluginTemplate\Inc\Presentation\Loaders;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class ReactDependenciesLoader extends AbstractSingleton
{
    public function register()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });
    }
}