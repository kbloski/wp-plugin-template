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
        $reactUrl = PluginPaths::getInstance()->getUrl("assets/React/React.js?v=". floor( time() / 1000));

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Hello React</div>
            <script type="module">
                const { createRoot, createElement} = wp.element;
                import { HelloReact } from "<?= $reactUrl ?>?v=<?= time() ?>";
                addEventListener('load', () => createRoot(document.querySelector("[data-react-id='<?= $elementId ?>']"))?.render(createElement(HelloReact, {})));
            </script>
        <?php
        return ob_get_clean();
    }

}
