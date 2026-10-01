<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na menu panelu administracyjnego.
 */
interface AdminMenuInterface
{
    /**
     * @param callable(): string $render Zwraca HTML strony
     */
    public function addPage(
        string $title,
        string $capability,
        string $slug,
        callable $render,
        string $iconUrl = '',
        ?int $position = null
    ): void;

    /**
     * @param callable(): string $render Zwraca HTML strony
     */
    public function addSubPage(
        string $parentSlug,
        string $title,
        string $capability,
        string $slug,
        callable $render
    ): void;
}
