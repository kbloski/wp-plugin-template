<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na środowisko, w którym działa wtyczka (ścieżki, adresy URL, katalogi).
 */
interface EnvironmentInterface
{
    /**
     * Absolutna ścieżka katalogu wtyczki (z końcowym ukośnikiem).
     *
     * @param string $pluginFile Plik główny wtyczki
     */
    public function pluginPath(string $pluginFile): string;

    /**
     * URL katalogu wtyczki (z końcowym ukośnikiem).
     *
     * @param string $pluginFile Plik główny wtyczki
     */
    public function pluginUrl(string $pluginFile): string;

    /**
     * Absolutna ścieżka w katalogu na dane zapisywane przez wtyczki.
     */
    public function contentPath(string $relativePath = ''): string;

    /**
     * Tworzy katalog (rekurencyjnie), jeśli nie istnieje.
     */
    public function ensureDirectory(string $path): bool;
}
