<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\EscaperInterface;

final class EscaperAdapter implements EscaperInterface
{
    public function html(string $text): string
    {
        return esc_html($text);
    }

    public function attr(string $text): string
    {
        return esc_attr($text);
    }

    public function url(string $url): string
    {
        return esc_url($url);
    }

    public function json(mixed $data): string
    {
        return (string) wp_json_encode($data);
    }
}
