<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Domain\I18n\TranslationsProvider;
use Throwable;

class TranslationsInjector extends AbstractSingleton
{
    private TranslationsProvider $translationsProvider;

    public function register(): void
    {
        $this->translationsProvider = new TranslationsProvider();
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

    private function getTranslations(): array
    {

        return $this->translationsProvider->get();
    }

    private function getVersion(): int
    {
        $file = PluginPaths::getInstance()
            ->getPluginPath("include/Domain/I18n/TranslationsProvider.php");

        return file_exists($file)
            ? filemtime($file)
            : time();
    }
}