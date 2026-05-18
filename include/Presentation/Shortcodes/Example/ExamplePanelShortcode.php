<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Example;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;

class ExamplePanelShortcode  extends AbstractShortcode
{
    protected array $atts = [];

    public function name(): string
    {
        return ShortcodeNamesEnum::API_COUNTER;
    }


    public function render_shortcode(array $atts = []): string
    {
        $elementId = uniqid();
        $reactUrl = PluginPaths::getInstance()->getUrl("assets/React/React.js?v=". floor( time() / 1000));

        ob_start()
        ?>
            <div data-react-id="<?= $elementId ?>">Example Panel</div>
            <script type="module">
                const { createRoot, createElement} = wp.element;
                import { ExamplePanel } from "<?= $reactUrl ?>?v=<?= time() ?>";
                addEventListener('DOMContentLoaded', () => createRoot(document.querySelector("[data-react-id='<?= $elementId ?>']"))?.render(createElement(ExamplePanel, {})));
            </script>
        <?php
        return ob_get_clean();
    }

}
