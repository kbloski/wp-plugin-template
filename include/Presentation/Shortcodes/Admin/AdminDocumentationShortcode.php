<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;

class AdminDocumentationShortcode extends AbstractShortcode
{
    public function name(): string 
    {
        return ShortcodeNamesEnum::ADMIN_DOCUMENTATION;
    }


    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>
        <div>
            <section><?= Translations::get('shortcodes')  ?></section>
            <?= do_shortcode("[".ShortcodeNamesEnum::SHORTCODES_DOCS."]") ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
