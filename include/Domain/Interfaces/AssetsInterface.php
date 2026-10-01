<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na kolejkę skryptów i stylów hosta.
 */
interface AssetsInterface
{
    /**
     * @param string $handle Uchwyt skryptu zarejestrowanego w hoście
     * @param bool $defer Ładowanie bez blokowania parsera
     */
    public function enqueueScript(string $handle, bool $defer = false): void;

    /**
     * @param string[] $deps
     */
    public function enqueueStyle(string $handle, string $url, array $deps = [], ?string $version = null): void;
}
