<?php

namespace PluginTemplate\Inc\Adapters\WordPress;

use PluginTemplate\Inc\Domain\Interfaces\ShortcodesInterface;
use WP_Post;

final class ShortcodesAdapter implements ShortcodesInterface
{
    public function register(string $name, callable $callback): void
    {
        // WordPress przekazuje pusty string zamiast tablicy, gdy shortcode nie ma atrybutów (WP < 6.5).
        add_shortcode($name, static fn($atts = [], $content = null, $tag = null) => $callback(
            is_array($atts) ? $atts : [],
            $content === null ? null : (string) $content,
            $tag === null ? null : (string) $tag
        ));
    }

    public function render(string $name, array $atts = []): string
    {
        $attributes = '';
        foreach ($atts as $key => $value) {
            $attributes .= sprintf(' %s="%s"', $key, esc_attr((string) $value));
        }

        return do_shortcode('[' . $name . $attributes . ']');
    }

    public function isUsedOnCurrentPage(string $name): bool
    {
        $post = get_post();

        return $post instanceof WP_Post && has_shortcode($post->post_content, $name);
    }
}
