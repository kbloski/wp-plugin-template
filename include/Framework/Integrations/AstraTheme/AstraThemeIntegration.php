<?php

namespace AstraToolbox\Inc\Integrations\AstraTheme;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Config\Options;
use AstraToolbox\Inc\DTOs\CookieDTO;
use AstraToolbox\Inc\Enums\CookiesMeta;
use AstraToolbox\Inc\Enums\OptionsEnum;
use AstraToolbox\Inc\Enums\PostMetaColorEnum;
use AstraToolbox\Inc\Enums\PostMetaEnum;
use AstraToolbox\Inc\Models\PostOverrideAstraVariablesModel;
use AstraToolbox\Inc\Stores\ThemeCookieStore;
use AstraToolbox\Inc\Utils\ColorsHelper;
use AstraToolbox\Inc\Utils\LoggerX;
use Throwable;

class AstraThemeIntegration extends AbstractSingleton
{
    private ThemeCookieStore $themeCookieStore;

    protected function __construct()
    {
        $this->themeCookieStore = ThemeCookieStore::getInstance();
    }

    public function init()
    {
        // add_action('template_redirect', function () {
        //     global $wp_query;

        //     // tylko front-end, nie admin, nie ajax, nie cron
        //     if (is_admin() || defined('DOING_AJAX') || defined('DOING_CRON')) {
        //         return;
        //     }

        //     // tylko główny query
        //     if (!$wp_query->is_main_query()) {
        //         return;
        //     }

        //     // Pobranie bieżącego URL
        //     $current_url = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        //     $current_url = strtolower($current_url);

        //     // Ignorowanie plików CSS/JS/ico itp.
        //     // if (preg_match('/\.(css|js|ico|png|jpg|svg|gif)$/i', $current_url)) {
        //     //     return;
        //     // }

        //     // Teraz logujemy TYLKO faktyczną stronę
        //     error_log("Główna strona URL: " . $current_url);
        // });










        // 1️⃣ Zapis ciasteczka jeśli strona ma aktywne kolory
        // add_action('wp', function () {
        //     // Sprawdzenie, czy to frontend i nie jest admin / ajax / cron
        //     if (is_admin() || defined('DOING_AJAX') || defined('DOING_CRON')) {
        //         return;
        //     }

        //     // Sprawdzenie, czy to "strona WordPress" — wpis lub strona
        //     if (!is_singular() && !function_exists('is_shop') && !is_shop()) {
        //         return; // wychodzimy jeśli to archiwum, home, 404 itp.
        //     }

        //     $post_id = 0;

        //     if (is_singular()) {
        //         $post_id = get_queried_object_id(); // wpis/strona
        //     } elseif (function_exists('is_shop') && is_shop()) {
        //         $post_id = wc_get_page_id('shop'); // WooCommerce shop
        //     }

        //     if ($post_id) {
        //         error_log("Post ID: " . $post_id);
        //         $this->themeCookieStore->udpateCookies($post_id);
        //     }
        // });


        // // 2️⃣ Generowanie CSS z cookie lub fallback na lokalne kolory
        // add_action('wp_enqueue_scripts', function () 
        // {
        //     global $post;
        //     $post_id = $post->ID ?? 0;
        //     if (!$post_id) return;

        //     $cookieDto = $this->themeCookieStore->getSettingsForPost($post_id);

        //     wp_add_inline_style('astra-theme-css', $this->createCss($cookieDto));

        // });

    }

    private function createCss(CookieDTO $cookieDTO): string
    {
        try {
            $css = '';

            $css = ':root, body {';
            foreach ($cookieDTO->astra_colors as $index => $color) 
            {
                if (empty($color['is_active'])) continue;
                $colorHex = $color['value'];
                
                $colorRGBa = ColorsHelper::hexWithAlphaToRgba($color['value'],(int) $color['alpha']);
                

                $css .= "--ast-global-color-$index: $colorRGBa;";

            }
            $css .= '}';

            // error_log($css);

            


            return $css;
        } catch (Throwable $e)
        {
            LoggerX::error($e->getMessage());
            throw $e;
        }
//         $css = '';
//         $colors = PostOverrideAstraVariablesModel::getColors( $postId );

//         error_log(json_encode($colors));

//         $astra_colors = $colors['astra_colors'];
//         $customColors = $colors['custom_colors'];

//         // ROOT 
//         $css = ':root, body {';
//         foreach ($astra_colors as $index => $color) {
//             if (empty($color->is_active)) continue;
//             $colorRGBa = ColorsHelper::hexWithAlphaToRgba($color->color, $color->alpha);
//             $css .= "--ast-global-color-$index: {$colorRGBa};";
//         }
//         $css .= '}';


//         // Custom Colors 
//         $footer_style = [
//             'background' => $customColors[PostMetaColorEnum::FOOTER_BACKGROUND()],
//             'color' => $customColors[PostMetaColorEnum::FOOTER_COLOR()]
//         ];
//         if (
//             !empty($footer_style['background'])
//         ) 
//         {
//             $css .= ' footer.site-footer > * {';

//             if ($footer_style['background']) 
//             {
//                 $color = $footer_style['background'];
//                 if (!empty($color) && !empty($color->is_active)) {
//                     $css .= " background: {$color->color} !important;";
//                 }
//             }
            
//             $css .= '}';
//         };

//         if (
//             !empty($footer_style['color'])
//         ) 
//         {
//             $css .= ' footer.site-footer * {';

//             if ($footer_style['color']) 
//             {
//                 $color = $footer_style['color'];
//                 if (!empty($color) && !empty($color->is_active)) {
//                     $css .= " color: {$color->color} !important;";
//                 }
//             }

//             $css .= '}';
//         };

   
//         return $css;
    }
}
