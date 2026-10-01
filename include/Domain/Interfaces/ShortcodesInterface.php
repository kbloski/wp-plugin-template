<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na mechanizm shortcode'ów hosta.
 */
interface ShortcodesInterface
{
    /**
     * @param callable(array, ?string, ?string): string $callback Otrzymuje atrybuty, treść i tag
     */
    public function register(string $name, callable $callback): void;

    /**
     * Renderuje shortcode o podanej nazwie.
     *
     * @param array<string, scalar> $atts
     */
    public function render(string $name, array $atts = []): string;

    /**
     * Czy shortcode występuje w treści aktualnie renderowanej strony.
     */
    public function isUsedOnCurrentPage(string $name): bool;
}
