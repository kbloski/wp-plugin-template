<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
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
            <section><?= Translations::get('shortcodes')  ?></section>
            <?= do_shortcode("[".ShortcodesNamesEnum::SHORTCODES_DOCS()."]") ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
