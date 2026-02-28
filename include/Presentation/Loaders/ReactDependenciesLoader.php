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

        // Dodanie własnych modułów React w stopce front-endu
        add_action('wp_head', [$this, 'enqueueReactScripts']);

        // Dodanie własnych modułów React w stopce panelu admina
        add_action('admin_head', [$this, 'enqueueReactScripts']);
    }

    public function enqueueReactScripts(): void
    {
        try {
            $pluginDirUrl = PluginPaths::getInstance()->getPluginUrl();
            $pluginDirPath = PluginPaths::getInstance()->getPluginPath();

            $assetsReactFolder = PluginPaths::getInstance()->getPath("assets/React/");
            $files = glob($assetsReactFolder . '**/*.js', GLOB_BRACE);

            foreach ($files as $filePath) {
                $relativePath = str_replace($pluginDirPath, '', $filePath);
                $fileUrl = $pluginDirUrl . str_replace('\\', '/', $relativePath);
                $ver = filemtime($filePath);
                $urlWithVer = "{$fileUrl}?v={$ver}";

                // Wygenerowanie <script> w stopce
                Logger::error(json_encode($urlWithVer));
                echo '<script src="' . esc_url($urlWithVer) . '" type="module"></script>' . PHP_EOL;
            }
        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }
}