<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

/**
 * Port na escapowanie danych wypisywanych do HTML.
 */
interface EscaperInterface
{
    public function html(string $text): string;

    public function attr(string $text): string;

    public function url(string $url): string;

    public function json(mixed $data): string;
}
