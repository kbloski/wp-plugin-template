<?php

namespace PluginTemplate\Inc\Presentation\Injectors;

use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;
use PluginTemplate\Inc\Domain\Interfaces\AssetsInterface;
use PluginTemplate\Inc\Domain\Interfaces\EscaperInterface;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;
use PluginTemplate\Inc\Domain\Interfaces\ShortcodesInterface;

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

    /**
     * Podstawowe skrypty hosta (React/REST)
     */
    private const HOST_SCRIPTS = ['wp-data', 'wp-element', 'wp-api-fetch'];

    public function __construct(
        private readonly HooksInterface $hooks,
        private readonly AssetsInterface $assets,
        private readonly ShortcodesInterface $shortcodes,
        private readonly EscaperInterface $escaper,
    )
    {
    }

    public function register()
    {
        // Wczytanie podstawowych skryptów WordPress (React/REST)
        $this->hooks->addAction('wp_enqueue_scripts', function () {
            foreach (self::HOST_SCRIPTS as $handle) {
                // Ładowanie bez blokowania parsera, ale wciąż gotowe bardzo wcześnie.
                $this->assets->enqueueScript($handle, defer: true);
            }
        });

        $this->hooks->addAction('admin_enqueue_scripts', function () {
            foreach (self::HOST_SCRIPTS as $handle) {
                $this->assets->enqueueScript($handle);
            }
        });

        $this->hooks->addAction('wp_head', [$this, 'injectModulePreloads'], 1);
    }

    /**
     * Wypisuje <link rel="modulepreload"> dla React.js oraz komponentów
     * shortcode'ów faktycznie obecnych na bieżącej stronie, żeby przeglądarka
     * pobrała/skompilowała moduły równolegle z resztą strony.
     */
    public function injectModulePreloads(): void
    {
        $modules = [];

        foreach (self::SHORTCODE_MODULE_MAP as $shortcodeName => $modulePath) {
            if ($this->shortcodes->isUsedOnCurrentPage($shortcodeName)) {
                $modules[] = $modulePath;
            }
        }

        if (empty($modules)) {
            return;
        }

        $paths = PluginPaths::getInstance();

        printf('<link rel="modulepreload" href="%s">' . "\n", $this->escaper->url($paths->getUrl('assets/React/React.js')));

        foreach ($modules as $modulePath) {
            printf('<link rel="modulepreload" href="%s">' . "\n", $this->escaper->url($paths->getUrl($modulePath)));
        }
    }
}
