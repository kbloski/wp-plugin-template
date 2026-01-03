<?php

namespace AstraToolbox\Inc\Enums;

use AstraToolbox\Inc\Config\Config;

class TableNamesEnum
{
    public static function PAGE_URLS(): string
    {
        global $wpdb;
        return $wpdb->prefix . Config::PLUGIN_SLUG . 'page_urls';
    }

    public static function PAGE_URL_META(): string
    {
        global $wpdb;
        return $wpdb->prefix . Config::PLUGIN_SLUG . 'page_url_meta';
    }

    public static function WP_USERS(): string
    {
        global $wpdb;
        return $wpdb->users;
    }

    public static function WP_USERMETA(): string
    {
        global $wpdb;
        return $wpdb->usermeta;
    }
}
