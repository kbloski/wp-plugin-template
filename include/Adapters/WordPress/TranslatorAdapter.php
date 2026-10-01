<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\TranslatorInterface;

/**
 * Katalog tłumaczeń wtyczki oparty o gettext WordPressa.
 * Nowe klucze dopisuje się w all().
 */
final class TranslatorAdapter implements TranslatorInterface
{
    public function all(): array
    {
        // Domain nie może pochodzić z klasy, musi to być ciąg znaków :/

        return [
            'hello.react' => __('❤️ Hello from REACT ❤️', "wp-plugin-template"),
            'counter' => __("Counter", "wp-plugin-template"),
            "shortcodes" => __("Shortcodes", "wp-plugin-template"),
            'button.increment' => __('Increment', "wp-plugin-template"),
            'button.decrement' => __('Decrement', "wp-plugin-template"),
            "action.generate"  => __("Generate", "wp-plugin-template"),
            "errors.unexpected_error" => __("Unexpected error occured", "wp-plugin-template")
        ];
    }

    public function get(string $key): string
    {
        $t = $this->all()[$key] ?? '';

        return (!empty($t) ? $t : $key);
    }

    public function version(): int
    {
        return (int) filemtime(__FILE__);
    }

    public function loadTextDomain(string $pluginFile): void
    {
        add_action('plugins_loaded', static function () use ($pluginFile) {
            load_plugin_textdomain(
                "wp-plugin-template",
                false,
                dirname(plugin_basename($pluginFile)) . '/languages'
            );
        });
    }
}
