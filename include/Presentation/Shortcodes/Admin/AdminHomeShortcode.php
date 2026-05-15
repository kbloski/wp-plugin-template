<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;

class AdminHomeShortcode extends AbstractShortcode
{
    public function name(): string
    {
        return ShortcodeNamesEnum::ADMIN_HOME;
    }

    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>
            <div>
                <h2>Home</h2>
                <?= do_shortcode("[" . ShortcodeNamesEnum::HELLO_REACT . "]" ); ?>
                <?= do_shortcode("[" . ShortcodeNamesEnum::COUNTER . "]" ); ?>
                <?= do_shortcode("[" . ShortcodeNamesEnum::PAGE_COUNTER . "]" ); ?>
                <?= do_shortcode("[" . ShortcodeNamesEnum::PAGE_COUNTER . "]" ); ?>
                <?= do_shortcode("[" . ShortcodeNamesEnum::API_COUNTER . "]" ); ?>

            </div>
        <?php
        return ob_get_clean();
    }
}