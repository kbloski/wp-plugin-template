<?php 

namespace PluginTemplate\Inc\Presentation\Admin;

use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;
use PluginTemplate\Inc\Domain\Interfaces\AdminMenuInterface;
use PluginTemplate\Inc\Domain\Interfaces\AssetsInterface;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;
use PluginTemplate\Inc\Domain\Interfaces\ShortcodesInterface;
use PluginTemplate\Inc\Domain\Security\Capabilities;

class AdminPages 
{
    public function __construct(
        private readonly HooksInterface $hooks,
        private readonly AdminMenuInterface $adminMenu,
        private readonly AssetsInterface $assets,
        private readonly ShortcodesInterface $shortcodes,
    )
    {
    }

    public function init()
    {
        $this->hooks->addAction('admin_enqueue_scripts', [$this, 'enqueueBrandingAssets']);

        $mainPageSlug = NameBuilder::applySlug('home');

        $this->adminMenu->addPage(
            PluginConfig::PLUGIN_NAME,
            Capabilities::ADMIN,
            $mainPageSlug,
            fn() => $this->shortcodes->render(ShortcodeNamesEnum::ADMIN_HOME),
            PluginPaths::getInstance()->getUrl('assets/Branding/logo.svg'),
            66
        );

        $this->adminMenu->addSubPage(
            $mainPageSlug,
            'Ustawienia',
            Capabilities::ADMIN,
            NameBuilder::applySlug("settings"),                //  Slug page
            fn() => $this->shortcodes->render(ShortcodeNamesEnum::ADMIN_SETTINGS)
        );

        $this->adminMenu->addSubPage(
            $mainPageSlug,
            'Dokumentacja',
            Capabilities::ADMIN,
            NameBuilder::applySlug("documentation"),                //  Slug page
            fn() => $this->shortcodes->render(ShortcodeNamesEnum::ADMIN_DOCUMENTATION)
        );
    }

    /** Zapewnia stały, proporcjonalny rozmiar logo w menu administracyjnym. */
    public function enqueueBrandingAssets(): void
    {
        $paths = PluginPaths::getInstance();
        $path = $paths->getPath('assets/Branding/admin-menu.css');

        $this->assets->enqueueStyle(
            NameBuilder::applyPrefix('admin-menu-branding'),
            $paths->getUrl('assets/Branding/admin-menu.css'),
            [],
            is_file($path) ? (string) filemtime($path) : null
        );
    }
}
