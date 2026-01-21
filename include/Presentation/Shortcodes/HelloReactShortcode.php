<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class HelloReactShortcode extends AbstractsAbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::HELLO_REACT();
    }

    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>
            <div data-react-root="hello-react">
                <?= $this->getShortcodeName() ?>
            </div>
        <?php
        return ob_get_clean();
    }

}
