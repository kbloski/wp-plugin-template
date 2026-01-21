<?php

namespace PluginTemplate\Inc\Framework\Loaders;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

class ReactLoader extends AbstractSingleton
{
    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_filter('script_loader_tag', [$this, 'addTypeModule'], 10, 3);
    }

    public function enqueueScripts()
    {
        // React roots
        $handle = NameBuilder::applyPrefix('assets-react-register_roots');
        $js = PluginPaths::getInstance()->getUrl('assets/React/RegisterRoots.js');
        $js_path = PluginPaths::getInstance()->getPath('assets/React/RegisterRoots.js');

        if (file_exists($js_path)) {
            wp_enqueue_script(
                $handle,
                $js,
                ['wp-element'],
                filemtime($js_path),
                true
            );
        }
    }

    /**
     * Dodaje type="module" do naszego handle
     */
    public function addTypeModule($tag, $handle, $src)
    {
        $moduleHandle = NameBuilder::applyPrefix('assets-react-register_roots');

        if ($handle === $moduleHandle) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }
}
