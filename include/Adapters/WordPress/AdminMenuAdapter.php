<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\AdminMenuInterface;

final class AdminMenuAdapter implements AdminMenuInterface
{
    public function addPage(
        string $title,
        string $capability,
        string $slug,
        callable $render,
        string $iconUrl = '',
        ?int $position = null
    ): void
    {
        add_action('admin_menu', static function () use ($title, $capability, $slug, $render, $iconUrl, $position) {
            add_menu_page(
                $title,
                $title,
                $capability,
                $slug,
                static function () use ($render) {
                    echo $render();
                },
                $iconUrl,
                $position
            );
        });
    }

    public function addSubPage(
        string $parentSlug,
        string $title,
        string $capability,
        string $slug,
        callable $render
    ): void
    {
        add_action('admin_menu', static function () use ($parentSlug, $title, $capability, $slug, $render) {
            add_submenu_page(
                $parentSlug,
                $title,
                $title,
                $capability,
                $slug,
                static function () use ($render) {
                    echo $render();
                }
            );
        });
    }
}
