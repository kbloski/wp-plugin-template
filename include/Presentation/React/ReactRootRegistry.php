<?php

namespace PluginTemplate\Inc\Presentation\React;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ReactRootsEnum;

class ReactRootRegistry extends AbstractSingleton
{
    protected function __construct()
    {
    }

    public function register(): void
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('wp-element');
        });

        add_action('wp_head', [$this, 'initReactRoots']);
    }

    /**
     * Bootstrap React root registry (inline ES module)
     */
    public function initReactRoots(): void
    {
        $indexReactUrl = PluginPaths::getInstance()->getUrl('/assets/React/index.js');

        ob_start();
        ?>
        <script type="module">
            const { createRoot, createElement } = wp.element;
            import * as ReactIndex from '<?= esc_url($indexReactUrl) ?>';



            // Dodawanie kolejnych komponentow reactowych
            const registryMap = {
                // "shortcode-name" : "component createElement"
                "<?= ReactRootsEnum::HELLO_REACT() ?>" : ReactIndex.HelloReactShortcode
            };




            // Budowanie rootow na stronie
            document.addEventListener('DOMContentLoaded', () => {
                Object.entries(registryMap).forEach(([key, Component]) => {
                    const selector = `[data-react-root="${key}"]`;
                    const elements = document.querySelectorAll(selector);

                    elements.forEach(el => {
                        const props = { el }

                        createRoot(el).render(
                            createElement(Component, {root: el})
                        );
                    });
                });
            });
        </script>
        <?php
        echo ob_get_clean();
    }
}
