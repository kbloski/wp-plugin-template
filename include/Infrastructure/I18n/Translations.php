<?php 

namespace PluginTemplate\Inc\Infrastructure\I18n;

class Translations
{

    public static function all() : array 
    {
        // Domain nie może pochodzić z klasy, musi to być ciąg znaków :/ 

        return [
            'hello.react' => __('❤️ Hello from REACT ❤️', "wp-plugin-template"),
            'button.increment' => __('Increment', "wp-plugin-template"),
            'button.decrement' => __('Decrement', "wp-plugin-template"),
            'counter' => __("Counter", "wp-plugin-template"),
            "shortcodes" => __("Shortcodes", "wp-plugin-template")
        ];
    }

    public static function get( string $key ) : string 
    {
        $translations = self::all();
        $t = $translations[$key];
        return (!empty($t) ? $t : $key); 
    }
}