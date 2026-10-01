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
                <?= $this->shortcodes()->render(ShortcodeNamesEnum::HELLO_REACT); ?>
                <?= $this->shortcodes()->render(ShortcodeNamesEnum::COUNTER); ?>
                <?= $this->shortcodes()->render(ShortcodeNamesEnum::PAGE_COUNTER); ?>
                <?= $this->shortcodes()->render(ShortcodeNamesEnum::EXAMPLE_PANEL); ?>

            </div>
        <?php
        return ob_get_clean();
    }
}