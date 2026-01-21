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

    
    /**
     */
    public function inlineJs(array $componentsMap) : string 
    {
        $indexReactUrl = PluginPaths::getInstance()->getUrl('/assets/React/index.js')

        ob_start();
        ?>
            <script type="module">
                import * as ComponentsModule from '<?= $indexReactUrl ?>';

                document.addEventListener('DOMContentLoaded', () => {
                    const componentsRegistry = {
                        // KEY : wp.element.createRoot()
                        'hello_react' : ComponentsModule.HelloReactShortcode 
                    };

                    // renderowanie komponentów
                    Object.entries(componentsRegistry).forEach(([key, Component]) => {
                        document.querySelectorAll(`[data-react-root="${key}"]`).forEach(el => {
                            wp.element.createRoot(el).render(
                                wp.element.createElement(Component, { instance: el.dataset.instance })
                            );
                        });
                    });
                });
            </script>
        <?php
        return ob_get_clean();
    }




    public function enqueueScripts() : void
    {
        $script_url = plugins_url('assets/React/index.js', PLUGIN_FILE);

        wp_register_script(
            $this->scriptHandle,
            $script_url,
            [], // dependencies jeśli potrzebne np. wp-element
            filemtime(PluginPaths::getPath('assets/React/index.js')),
            true
        );

        wp_enqueue_script($this->scriptHandle);
    }

    public function addTypeModule($tag, $handle, $src) : string
    {
        if ($handle === $this->scriptHandle) {
            $tag = str_replace('<script ', '<script type="module" ', $tag);
        }
        return $tag;
    }

}
