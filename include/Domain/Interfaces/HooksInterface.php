<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na system zdarzeń hosta (akcje, filtry, cykl życia wtyczki).
 */
interface HooksInterface
{
    public function addAction(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void;

    public function addFilter(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): void;

    public function doAction(string $hook, mixed ...$args): void;

    public function applyFilters(string $hook, mixed $value, mixed ...$args): mixed;

    /**
     * @param string $pluginFile Plik główny wtyczki
     */
    public function onActivation(string $pluginFile, callable $callback): void;

    /**
     * @param string $pluginFile Plik główny wtyczki
     */
    public function onDeactivation(string $pluginFile, callable $callback): void;
}
