<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
use Throwable;

class TranslationsInjector
{
    public function register(): void
    {
        add_action('wp_footer',  fn() => $this->inject());
        add_action('admin_footer', fn() => $this->inject());
    }

    private function inject(): void
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

    private function getTranslations(): array
    {

        return Translations::all();
    }

    private function getVersion(): int
    {
        $file = PluginPaths::getInstance()
            ->getPluginPath("include/Infrastructure/I18n/Translations.php");

        return file_exists($file)
            ? filemtime($file)
            : time();
    }
}