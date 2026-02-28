<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\React;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class GlobalReactStoreShortcode extends AbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::GLOBAL_REACT_STORE();
    }


    public function render_shortcode(array $atts = []): string
    {
        $elementId = uniqid();
        $componentUrl = PluginPaths::getInstance()->getUrl("assets/React/Shortcodes/GlobalReactStoreShortcode/GlobalReactStoreShortcode.js");

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Global React Store</div>
            <script type="module">
                const { createRoot, createElement} = wp.element;
                import Component from "<?= $componentUrl ?>?v=<?= time() ?>";
                addEventListener('load', () => createRoot(document.querySelector("[data-react-id='<?= $elementId ?>']"))?.render(createElement(Component, {})));
            </script>
        <?php
        return ob_get_clean();
    }

}
