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
        // add_action('wp_enqueue_scripts', function () {
        //     wp_enqueue_script('wp-element');
        //     wp_enqueue_script('wp-api-fetch');
        // });
    }

    public function render_shortcode(array $atts = []): string
    {
        $elementId = uniqid();
        $reactUrl = PluginPaths::getInstance()
            ->getUrl("assets/React");

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Hello React Root</div>

            <script type="module">
                const { createRoot, createElement, useState } = wp.element;
                import Counter from "<?= $reactUrl ?>/Components/Counter.js?v=<?= time() ?>";
                import GlobalStore from "<?= $reactUrl ?>/Components/GlobalStore.js?v=<?= time() ?>";
                
                // console.log("<?= $reactUrl ?>/Components/Counter.js")

                addEventListener('load', () => { 
                    const element = document.querySelector("[data-react-id='<?= $elementId ?>']");
                    mount(element); 
                });

                // React
                function mount(rootEl) 
                {
                    // Root
                    createRoot(rootEl)
                        .render(
                            createElement(
                                'div', null,
                                createElement("div", null,'❤️ Hello from REACT ❤️'),
                                createElement(Counter, {}),
                                createElement("div", null, "Global store usage"),
                                createElement(GlobalStore, {})
                            ),
                        );
                }
            </script>
        <?php
        return ob_get_clean();
    }

}
