<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class AdminHomeShortcode extends AbstractShortcode
{
    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::ADMIN_HOME();
    }

    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>
            <?=  do_shortcode("[". ShortcodesNamesEnum::HELLO_REACT(). "]") ?>

        <?php
        return ob_get_clean();
    }
    }