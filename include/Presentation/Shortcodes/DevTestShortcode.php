<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class DevTestShortcode extends AbstractsAbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::DEV_TEST();
    }

    public function enqueue_assets(): void
    {
    }


    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>

        <div>Developerski component testowy</div>

        <?php
        return ob_get_clean();
    }

}
