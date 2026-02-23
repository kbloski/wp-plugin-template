<?php

namespace PluginTemplate\Inc\Core\Configs;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

/**
 * Klasa helper do pobierania ścieżek i URL wtyczki
 */
class PluginPaths extends AbstractSingleton
{
    /**
     * Absolutna ścieżka do katalogu głównego wtyczki
     *
     * @var string
     */
    private string $plugin_path;

    /**
     * URL do katalogu głównego wtyczki
     *
     * @var string
     */
    private string $plugin_url;

    /**
     * Konstruktor klasy
     *
     * @param string $file Plik główny wtyczki (zwykle __FILE__)
     */
    public function init(string $file)
    {
        $this->plugin_path = plugin_dir_path($file);
        $this->plugin_url  = plugin_dir_url($file);
    }

    /**
     * Zwraca ścieżkę do katalogu głównego wtyczki
     *
     * @return string
     */
    public function getPluginPath(): string
    {
        return $this->plugin_path;
    }

    /**
     * Zwraca URL do katalogu głównego wtyczki
     *
     * @return string
     */
    public function getPluginUrl(): string
    {
        return $this->plugin_url;
    }

    /**
     * Zwraca absolutną ścieżkę do pliku lub folderu w katalogu wtyczki
     *
     * @param string $relative_path Ścieżka relatywna względem katalogu wtyczki
     * @return string
     */
    public function getPath(string $relative_path): string
    {
        return $this->plugin_path . ltrim($relative_path, '/');
    }

    /**
     * Zwraca URL do pliku lub folderu w katalogu wtyczki
     *
     * @param string $relative_path Ścieżka relatywna względem katalogu wtyczki
     * @return string
     */
    public function getUrl(string $relative_path): string
    {
        return $this->plugin_url . ltrim($relative_path, '/');
    }
}
