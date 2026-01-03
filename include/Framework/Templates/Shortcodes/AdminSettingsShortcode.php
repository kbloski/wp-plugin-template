<?php

namespace AstraToolbox\Inc\Templates\Shortcodes;

use AstraToolbox\Inc\Abstracts\AbstractShortcode;
use AstraToolbox\Inc\Services\SettingsService;
use AstraToolbox\Inc\Enums\ShortcodesNamesEnum;

class AdminSettingsShortcode extends AbstractShortcode
{
    private SettingsService $settingsService;

    protected function __construct()
    {
        $this->settingsService = SettingsService::getInstance();
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
