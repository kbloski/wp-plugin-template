<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;

class ReactAssetsInjector
{
    /**
     * Mapa shortcode -> plik komponentu, który należy zmodulepreloadować,
     * gdy dany shortcode występuje na aktualnie renderowanej stronie.
     */
    private const SHORTCODE_MODULE_MAP = [
        ShortcodeNamesEnum::HELLO_REACT   => 'assets/React/Features/Hello/Shortcodes/HelloReact/HelloReact.js',
        ShortcodeNamesEnum::COUNTER       => 'assets/React/Features/Counter/Shortcodes/Counter/Counter.js',
        ShortcodeNamesEnum::PAGE_COUNTER  => 'assets/React/Features/Counter/Shortcodes/GlobalCounter/GlobalCounter.js',
        ShortcodeNamesEnum::EXAMPLE_PANEL => 'assets/React/Features/Example/Shortcodes/ExamplePanel/ExamplePanel.js',
    ];

    public function register()
    {
        // Wczytanie podstawowych skryptów WordPress (React/REST)
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');

            // Ładowanie bez blokowania parsera, ale wciąż gotowe bardzo wcześnie (WP 6.3+, no-op na starszych).
            wp_script_add_data('wp-data', 'strategy', 'defer');
            wp_script_add_data('wp-element', 'strategy', 'defer');
            wp_script_add_data('wp-api-fetch', 'strategy', 'defer');
        });

        add_action('admin_enqueue_scripts', function () {
            wp_enqueue_script('wp-data');
            wp_enqueue_script('wp-element');
            wp_enqueue_script('wp-api-fetch');
        });

        add_action('wp_head', [$this, 'injectModulePreloads'], 1);
    }

    /**
     * Wypisuje <link rel="modulepreload"> dla React.js oraz komponentów
     * shortcode'ów faktycznie obecnych na bieżącej stronie, żeby przeglądarka
     * pobrała/skompilowała moduły równolegle z resztą strony.
     */
    public function injectModulePreloads(): void
    {
        $post = get_post();

        if (!$post instanceof \WP_Post) {
            return;
        }

        $modules = [];

        foreach (self::SHORTCODE_MODULE_MAP as $shortcodeName => $modulePath) {
            if (has_shortcode($post->post_content, $shortcodeName)) {
                $modules[] = $modulePath;
            }
        }

        if (empty($modules)) {
            return;
        }

        $paths = PluginPaths::getInstance();

        printf('<link rel="modulepreload" href="%s">' . "\n", esc_url($paths->getUrl('assets/React/React.js')));

        foreach ($modules as $modulePath) {
            printf('<link rel="modulepreload" href="%s">' . "\n", esc_url($paths->getUrl($modulePath)));
        }
    }
}