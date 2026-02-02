<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class AdminSettingsShortcode extends AbstractShortcode
{
    protected function __construct()
    {
    }

    public function getShortcodeName(): string 
    {
        return ShortcodesNamesEnum::ADMIN_SETTINGS();
    }

    public function render_shortcode(array $atts = []): string
    {
       
        return ob_get_clean();
    }


}
