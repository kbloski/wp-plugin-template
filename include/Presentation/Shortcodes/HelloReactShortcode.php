<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class HelloReactShortcode extends AbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::HELLO_REACT();
    }


    public function render_shortcode(array $atts = []): string
    {
        $elementId = uniqid();
        $componentUrl = PluginPaths::getInstance()->getUrl("assets/React/Shortcodes/HelloReactShortcode.js");

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Hello React Root</div>

            <script type="module">
                import Component from "<?= $componentUrl ?>?v=<?= time() ?>";
                const { createRoot, createElement, useState } = wp.element;
                addEventListener('load', () => { 
                    const element = document.querySelector("[data-react-id='<?= $elementId ?>']");
                    createRoot(element).render(createElement(Component, {}));
                });
            </script>
        <?php
        return ob_get_clean();
    }

}
