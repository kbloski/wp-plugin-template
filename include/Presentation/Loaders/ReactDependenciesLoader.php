<?php 

namespace PluginTemplate\Inc\Presentation\Loaders;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class ReactDependenciesLoader extends AbstractSingleton
{
    public function register()
    {
        // Frontend
        add_action('wp_enqueue_scripts', function () {

            // Wbudowane skrypty WordPressa
            wp_enqueue_script('wp-element');     // React
            wp_enqueue_script('wp-api-fetch');   // REST API
            wp_enqueue_script('wp-data');        // wp.data store
        });

        // Admin
        add_action('admin_enqueue_scripts', function () {

            // Wbudowane skrypty WordPressa
            wp_enqueue_script('wp-element');     
            wp_enqueue_script('wp-api-fetch');   
            wp_enqueue_script('wp-data');        
        });
    }
}