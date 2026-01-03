<?php

namespace AstraToolbox\Inc\Utils;

class WPHelper {
    /**
     * Pobiera URL strony głównej serwisu.
     *
     * @param string $path Opcjonalna ścieżka do dodania do URL, np. '/login'
     * @return string
     */
    public static function home_url(string $path = ''): string
    {
        return esc_url(home_url($path));
    }

    public static function sanitize_text($text) {
        return sanitize_text_field($text);
    }

    public static function redirect(string $url) {
        wp_safe_redirect($url);
        exit;
    }
}
