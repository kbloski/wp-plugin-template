<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na tłumaczenia.
 */
interface TranslatorInterface
{
    /**
     * @return array<string, string> klucz => przetłumaczony tekst
     */
    public function all(): array;

    /**
     * Zwraca tłumaczenie, a gdy go brak — sam klucz.
     */
    public function get(string $key): string;

    /**
     * Wersja katalogu tłumaczeń (do unieważniania cache po stronie przeglądarki).
     */
    public function version(): int;

    /**
     * @param string $pluginFile Plik główny wtyczki
     */
    public function loadTextDomain(string $pluginFile): void;
}
