<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na trwały magazyn opcji (klucz => wartość).
 */
interface OptionsStoreInterface
{
    public function get(string $name, mixed $default = null): mixed;

    public function set(string $name, mixed $value): void;

    public function delete(string $name): void;
}
