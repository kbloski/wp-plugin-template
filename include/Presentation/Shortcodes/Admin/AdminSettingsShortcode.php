<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;

class AdminSettingsShortcode extends AbstractShortcode
{


    public function name(): string 
    {
        return ShortcodeNamesEnum::ADMIN_SETTINGS;
    }

    public function render_shortcode(array $atts = []): string
    {
       
        return ob_get_clean();
    }


}
