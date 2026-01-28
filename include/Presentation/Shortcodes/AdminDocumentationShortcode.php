<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Presentation\Shortcodes;

class AdminDocumentationShortcode extends AbstractShortcode
{
    public function getShortcodeName(): string 
    {
        return ShortcodesNamesEnum::ADMIN_DOCUMENTATION();
    }


    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>
        <div>
            <section>Endpoints</section>
            <?= do_shortcode("[".ShortcodesNamesEnum::ENDPOINTS_DOCS()."]") ?>
            <hr>
            <section>Shortcody</section>
            <?= do_shortcode("[".ShortcodesNamesEnum::SHORTCODES_DOCS()."]") ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
