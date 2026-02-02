<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Presentation\Shortcodes;
use Throwable;

class ShortcodesDocsShortcode extends AbstractShortcode
{
    public function getShortcodeName(): string 
    {
        return ShortcodesNamesEnum::SHORTCODES_DOCS();
    }

    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>
            <ul>
                <?php foreach (Shortcodes::getInstance()->getShortcodesDocumentation() as $shortcode => $details): ?>
                    <li>
                        <div>[<?= esc_html($shortcode) ?>]</div>
                        <div>
                            <pre><?= esc_html(json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php
        return ob_get_clean();
    }
}