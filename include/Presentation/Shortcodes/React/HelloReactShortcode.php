<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\React;

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
        $componentUrl = PluginPaths::getInstance()->getUrl("assets/React/Shortcodes/HelloReactShortcode/HelloReactShortcode.js");

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Hello React Root</div>
            <script type="module">
                const { createRoot, createElement} = wp.element;
                import Component from "<?= $componentUrl ?>?v=<?= time() ?>";
                addEventListener('load', () => createRoot(document.querySelector("[data-react-id='<?= $elementId ?>']"))?.render(createElement(Component, {})));
            </script>
        <?php
        return ob_get_clean();
    }

}
