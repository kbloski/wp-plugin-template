<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use Throwable;

class TranslationsInjector extends AbstractSingleton
{
    public function register(): void
    {
        // lepsze miejsce niż wp_head/admin_head (React + DOM safety)
        add_action('wp_footer', [$this, 'inject']);
        add_action('admin_footer', [$this, 'inject']);
    }

    public function inject(): void
    {
        try {
            $translations = $this->getTranslations();
            $windowPropName = "__" . NameBuilder::applySlug("TRANSLATIONS");

            $payload = [
                'version' => $this->getVersion(),
                'data'    => $translations,
            ];

            echo '<script>';
            echo 'window.' . esc_js($windowPropName) . ' = ' . wp_json_encode($payload) . ';';
            echo '</script>' . PHP_EOL;

        } catch (Throwable $e) {
            Logger::error($e);
        }
    }

    /**
     * Źródło tłumaczeń:
     * - Loco Translate
     * - gettext __()
     * - future DB / API
     */
    private function getTranslations(): array
    {
        return [
            'button.increment' => __('Increment', 'wp-plugin-template'),
            'button.decrement' => __('Decrement', 'wp-plugin-template'),
            'button.save'      => __('Save', 'wp-plugin-template'),
        ];
    }

    /**
     * Version tłumaczeń (cache invalidation)
     * NIE opieramy tego o filemtime, bo tłumaczenia są poza plikami PHP.
     */
    private function getVersion(): int
    {
        $file = __FILE__;

        return file_exists($file)
            ? filemtime($file)
            : time();
    }
}