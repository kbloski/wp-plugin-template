<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Counter;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class CounterShortcode extends AbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::COUNTER();
    }


    public function render_shortcode(array $atts = []): string
    {
        $elementId = uniqid();
        $reactUrl = PluginPaths::getInstance()->getUrl("assets/React/React.js?v=". floor( time() / 1000));

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Counter</div>
            <script type="module">
                const { createRoot, createElement} = wp.element;
                import { Counter } from "<?= $reactUrl ?>?v=<?= time() ?>";
                addEventListener('load', () => createRoot(document.querySelector("[data-react-id='<?= $elementId ?>']"))?.render(createElement(Counter, {})));
            </script>
        <?php
        return ob_get_clean();
    }

}
