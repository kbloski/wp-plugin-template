<?php

namespace AstraToolbox\Inc\Templates\Shortcodes;

use AstraToolbox\Inc\Abstracts\AbstractShortcode;
use AstraToolbox\Inc\Enums\ShortcodesNamesEnum;
use WC_Product;
use AstraToolbox\Inc\Utils\AssetsLoader;

class DevTestShortcode extends AbstractShortcode
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
