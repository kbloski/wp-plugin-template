<?php

namespace AstraToolbox\Inc\Templates\Shortcodes;

use AstraToolbox\Inc\Abstracts\AbstractShortcode;
use AstraToolbox\Inc\Enums\ShortcodesNamesEnum;
use AstraToolbox\Inc\Templates\ShortcodesManager;

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
            <section>
                <h2>Endpoints</h2>
            </section>

            <hr>

            <section>
                <h2>Shortcody</h2>
                <ul>
                    <?php foreach (ShortcodesManager::getInstance()->getShortcodesDocumentation() as $shortcode => $details): ?>
                        <li>
                            <div>[<?= esc_html($shortcode) ?>]</div>
                            <div>
                                <pre><?= esc_html(json_encode($details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
        <?php
        return ob_get_clean();
    }
}
