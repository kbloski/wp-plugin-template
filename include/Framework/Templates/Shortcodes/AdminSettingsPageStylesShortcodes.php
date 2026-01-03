<?php

namespace AstraToolbox\Inc\Templates\Shortcodes;

use AstraToolbox\Inc\Abstracts\AbstractShortcode;
use AstraToolbox\Inc\Config\Options;
use AstraToolbox\Inc\DTOs\CookieColorDTO;
use AstraToolbox\Inc\Enums\OptionsEnum;
use AstraToolbox\Inc\Enums\ShortcodesNamesEnum;
use AstraToolbox\Inc\Enums\PostMetaColorEnum;
use AstraToolbox\Inc\Enums\PostMetaEnum;
use AstraToolbox\Inc\Enums\ThemeColorOverrideModeEnum;
use AstraToolbox\Inc\Stores\ThemeCookieStore;
use AstraToolbox\Inc\Templates\Components\PostSelectFieldComponent;
use AstraToolbox\Inc\Utils\LoggerX;
use Throwable;

class AdminSettingsPageStylesShortcodes extends AbstractShortcode
{
    private ThemeCookieStore $themeCookiesStore;
    private array $astraColorFields;
    private array $customColorFields;

    protected function __construct()
    {
        $this->themeCookiesStore = ThemeCookieStore::getInstance();

        // 9 kolorów ASTRA
        $this->astraColorFields = [
            'brand' => PostMetaColorEnum::BRAND(),
            'alt_brand' => PostMetaColorEnum::ALT_BRAND(),
            'heading' => PostMetaColorEnum::HEADING(),
            'text' => PostMetaColorEnum::TEXT(),
            'primary' => PostMetaColorEnum::PRIMARY(),
            'secondary' => PostMetaColorEnum::SECONDARY(),
            'border' => PostMetaColorEnum::BORDER(),
            'subtle_background' => PostMetaColorEnum::SUBTLE_BACKGROUND(),
            'accent' => PostMetaColorEnum::ACCENT(),
        ];

        // własne kolory
        $this->customColorFields = [
            'footer_background' => PostMetaColorEnum::FOOTER_BACKGROUND(),
            'footer_color' => PostMetaColorEnum::FOOTER_COLOR()
        ];
    }

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::ADMIN_SETTINGS_PAGES_STYLES();
    }

    public function render_shortcode(array $atts = []): string
    {
        ob_start();

        
        $selected_page = isset($_POST['selected_page_id']) ? (int) $_POST['selected_page_id'] : 0;
        
        echo $this->handlePostColors($selected_page);
        
        ?>
        <!-- Formularz wyboru strony -->
        <form method="post">
            <?php
            echo PostSelectFieldComponent::getInstance()->render([
                'name' => 'selected_page_id',
                'value' => $selected_page,
                'onchange' => 'this.form.submit()',
            ]);
            ?>
        </form>

        <?php if ($selected_page): ?>
            <hr>
            <form method="post">
                <?php wp_nonce_field('astra_page_styles_save', 'astra_page_styles_nonce'); ?>
                <input type="hidden" name="selected_page_id" value="<?= esc_attr($selected_page) ?>">

                <h3>Page #<?= $selected_page ?></h3>
                <?php 
                    $isColorOverrideActive = !empty(get_post_meta($selected_page, PostMetaEnum::theme_style_override_enabled(), true)); 
                ?>
                <label>
                    <input type="checkbox" name="theme_style_override_enabled" <?= checked($isColorOverrideActive) ?>>
                    Aktywuj nadpisywanie kolorów globalnych po wejściu na tą stronę dla wszystkich stron
                </label>

                <h3>Kolory ASTRA</h3>

                    <?php 
                    foreach ($this->astraColorFields as $label => $metaKey):
                        $meta = get_post_meta($selected_page, $metaKey, true); 
                    ?>
                    <p>
                        <label><strong><?= esc_html(ucwords(str_replace('_', ' ', $label))) ?></strong></label>
                        <input type="color" name="colors[<?= esc_attr($metaKey) ?>]" value="<?= esc_attr($meta->color ?? '') ?>">
                        <label>Alpha:</label>
                        <input type="number" name="colors_alpha[<?= esc_attr($metaKey) ?>]" value="<?= esc_attr($meta->alpha ?? 1) ?>" min="0" max="1" step="0.01">
                        <label>Active:</label>
                        <input type="checkbox" name="colors_active[<?= esc_attr($metaKey) ?>]" value="1" <?= checked($meta->is_active ?? false, true, false) ?>>
                    </p>
                <?php endforeach; ?>

                <h3>Kolory własne</h3>
                <?php foreach ($this->customColorFields as $label => $metaKey):
                    $meta = get_post_meta($selected_page, $metaKey, true); ?>
                    <p>
                        <label><strong><?= esc_html(ucwords(str_replace('_', ' ', $label))) ?></strong></label>
                        <input type="color" name="colors[<?= esc_attr($metaKey) ?>]" value="<?= esc_attr($meta->color ?? '') ?>">
                        <label>Alpha:</label>
                        <input type="number" name="colors_alpha[<?= esc_attr($metaKey) ?>]" value="<?= esc_attr($meta->alpha ?? 1) ?>" min="0" max="1" step="0.01">
                        <label>Active:</label>
                        <input type="checkbox" name="colors_active[<?= esc_attr($metaKey) ?>]" value="1" <?= checked($meta->is_active ?? false, true, false) ?>>
                    </p>
                <?php endforeach; ?>

                <p>
                    <input type="submit" class="button button-primary" value="Zapisz kolory">
                </p>
            </form>
        <?php endif;

        return ob_get_clean();
    }



    private function handlePostColors(int $selected_post_id): string
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') return '';
            if (!isset($_POST['astra_page_styles_nonce']) || !wp_verify_nonce($_POST['astra_page_styles_nonce'], 'astra_page_styles_save')) return '';
            if (!$selected_post_id) return '';

            $themeStyleOverrideEnabled = isset($_POST['theme_style_override_enabled']);
            update_post_meta($selected_post_id, PostMetaEnum::THEME_STYLE_OVERRIDE_ENABLED(), $themeStyleOverrideEnabled);

            // 9 kolorów ASTRA
            foreach ($this->astraColorFields as $metaKey) {
                $value = sanitize_text_field($_POST['colors'][$metaKey] ?? '');
                $alpha = floatval($_POST['colors_alpha'][$metaKey] ?? 1);
                $isActive = isset($_POST['colors_active'][$metaKey]);

                $dto =  new CookieColorDTO([
                    'meta_key' => $metaKey,
                    'is_active' => $isActive,
                    'value' => $value,
                    'alpha' => $alpha
                ]);
                
                $this->themeCookiesStore->setColor($selected_post_id, $dto);

            }

            // własne kolory
            foreach ($this->customColorFields as $metaKey) {
                $value = sanitize_text_field($_POST['colors'][$metaKey] ?? '');
                $alpha = floatval($_POST['colors_alpha'][$metaKey] ?? 1);
                $isActive = isset($_POST['colors_active'][$metaKey]);

                $this->themeCookiesStore->setColor($selected_post_id, new CookieColorDTO([
                    'meta_key' => $metaKey,
                    'is_active' => $isActive,
                    'value' => $value,
                    'alpha' => $alpha
                ]));
            }

            return '<div class="updated notice"><p>Kolory zapisane poprawnie.</p></div>';
        } catch (Throwable $e) {
            LoggerX::error($e->getMessage());
            return '<div class="error notice"><p>Błąd zapisu kolorów.</p></div>';
        }
    }
}
