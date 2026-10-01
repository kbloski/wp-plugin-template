<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use FilesystemIterator;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Interfaces\EscaperInterface;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;
use PluginTemplate\Inc\Domain\Interfaces\TranslatorInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;

class VariablesInjector
{
    private readonly string $assetsPath;

    public function __construct(
        private readonly HooksInterface $hooks,
        private readonly EscaperInterface $escaper,
        private readonly TranslatorInterface $translator,
    )
    {
        $this->assetsPath = PluginPaths::getInstance()->getPath("assets/");
    }

    public function register(): void
    {
        $this->hooks->addAction('wp_footer',  fn() => $this->inject());
        $this->hooks->addAction('admin_footer', fn() => $this->inject());
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
                    window.__<?= PluginConfig::NAMESPACE ?> = <?= $this->escaper->json($payload) ?> ;
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

        return $this->translator->all();
    }

    private function getTranslationsVersion(): int
    {
        return $this->translator->version();
    }
}