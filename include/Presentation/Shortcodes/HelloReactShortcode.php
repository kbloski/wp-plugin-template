<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ReactRootsEnum;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Presentation\React\ReactRootRenderer;
use Respect\Validation\Rules\Unique;

class HelloReactShortcode extends AbstractsAbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::HELLO_REACT();
    }

    public function enqueue_assets(): void
    {
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });
    }

    public function render_shortcode(array $atts = []): string
    {
        $elementId = uniqid();

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>"></div>
            <script type="module">
                const { createRoot, createElement, useState } = wp.element;
                addEventListener('load', () => mount(document.querySelector("[data-react-id='<?= $elementId ?>']")) )

                // React
                function mount(rootEl) 
                {

                    // Root
                    createRoot(rootEl).render(
                        createElement(
                            'div', null,
                            '❤️ Hello from REACT ❤️',
                            createElement(component, {})
                        ),
                    );
                }

                function component()
                {
                    const [counter, setCounter] = useState(0)

                    return createElement("div", {}, 
                        createElement("div", {}, `Counter: ${counter}` ),

                        createElement("div", {}, 
                            createElement("button", { onClick: () => setCounter(p => ++p)}, "Increment"),
                            createElement("button", { onClick: () => setCounter(p => --p)}, "Decrement"),
                        )
                    )
                }
            </script>
        <?php
        return ob_get_clean();
    }

}
