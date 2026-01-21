<?php

namespace PluginTemplate\Inc\Presentation\React;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

class ReactLoader extends AbstractSingleton
{
    private string $scriptHandle;

    public function register() : void 
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_filter('script_loader_tag', [$this, 'addTypeModule'], 10, 3);

        $this->scriptHandle = NameBuilder::applyPrefix('assets-react-register_roots');
    }

    public function enqueueScripts()
    {
        // React roots
        $js = PluginPaths::getInstance()->getUrl('include/Presentation/React/RegisterRoots.js');
        $js_path = PluginPaths::getInstance()->getPath('include/Presentation/React/RegisterRoots.js');

        if (file_exists($js_path)) {
            wp_enqueue_script(
                $this->scriptHandle,
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
        if ($handle === $this->scriptHandle) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }

        return $tag;
    }
}