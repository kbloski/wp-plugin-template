<?php 

namespace PluginTemplate\Inc\Presentation\Loaders;

use Finance\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Logger\Logger;
use Throwable;

class ReactDependenciesLoader extends AbstractSingleton
{
    public function register()
    {
        add_action('wp_enqueue_scripts', function () 
        {
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });

        add_action('admin_enqueue_scripts', function () 
        {
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });

        $this->enqueueReactScripts();
    }

    private function enqueueReactScripts() : void 
    {
        try 
        {
            $pluginDirUrl = PluginPaths::getInstance()->getPluginUrl();
            $pluginDirPath = PluginPaths::getInstance()->getPluginPath();

            $assetsReactFolder = PluginPaths::getInstance()->getPath("assets/React/");
            $files = glob($assetsReactFolder . '**/*.js', GLOB_BRACE);

            foreach ($files as $filePath) {
                $fileUrl =  $pluginDirUrl. str_replace($pluginDirUrl, '', $filePath);
                $ver = filemtime($filePath);
                $handle = str_replace([$pluginDirPath, '/', '.'], ['', '-', '-'], $filePath);

                wp_enqueue_script(
                    $handle,
                    $fileUrl,
                    ['wp-element', 'wp-data'], 
                    $ver,
                    true
                );
            }
        }
        catch (Throwable $e)
        {
            Logger::error($e);
            throw $e;
        }
    }
}