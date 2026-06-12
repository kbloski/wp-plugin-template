<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use FilesystemIterator;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Infrastructure\I18n\Translations;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;

class VariablesInjector
{
    private readonly string $assetsPath;

    public function __construct()
    {
        $this->assetsPath = PluginPaths::getInstance()->getPath("assets/");
    }

    public function register(): void
    {
        add_action('wp_footer',  fn() => $this->inject());
        add_action('admin_footer', fn() => $this->inject());
    }

    private function inject(): void
    {
        try 
        {
            $payload = 
            [
                "config" => [
                    "version" => $this->getConfigVersion(),
                ],
                "translations" => [
                    'version' => $this->getTranslationsVersion(),
                    'data'    => $this->getTranslations()
                ],
            ];

            ob_start()
            ?>
                <script>
                    window.__<?= PluginConfig::NAMESPACE ?> = <?= wp_json_encode($payload) ?> ;
                </script>
            <?php
            echo ob_get_clean();
            
        } catch (Throwable $e) {
            Logger::error($e);
        }
    }

    private function getConfigVersion(): int
    {
        $assetsPath = $this->assetsPath;

        $maxTime = 0;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $assetsPath,
                 FilesystemIterator::SKIP_DOTS
            )
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $maxTime = max($maxTime, $file->getMTime());
            }
        }

        return $maxTime;
    }

    private function getTranslations(): array
    {

        return Translations::all();
    }

    private function getTranslationsVersion(): int
    {
        $file = PluginPaths::getInstance()
            ->getPluginPath("include/Infrastructure/I18n/Translations.php");

        return file_exists($file)
            ? filemtime($file)
            : time();
    }
}