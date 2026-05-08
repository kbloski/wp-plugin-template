<?php 

namespace PluginTemplate\Inc\Infrastructure\I18n;

class Translations
{

    public static function all() : array 
    {
        // Domain nie może pochodzić z klasy, musi to być ciąg znaków :/ 

        return [
            'hello.react' => __('❤️ hello from REACT ❤️', "wp-plugin-template"),
            'button.increment' => __('increment', "wp-plugin-template"),
            'button.decrement' => __('decrement', "wp-plugin-template"),
            'counter' => __("counter", "wp-plugin-template"),
            "shortcodes" => __("shortcodes", "wp-plugin-template")
        ];
    }

    public static function get( string $key ) : string 
    {
        $translations = self::all();
        $t = $translations[$key];
        return (!empty($t) ? $t : $key); 
    }
}