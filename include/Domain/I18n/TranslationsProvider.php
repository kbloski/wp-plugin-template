<?php 

namespace PluginTemplate\Inc\Domain\I18n;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginConfig;

class TranslationsProvider
{
    public function get() : array 
    {
        // Domain nie może pochodzić z klasy, musi to być ciąg znaków :/ 

        return [
            'hello.react' => __('❤️ Hello from REACT ❤️', "wp-plugin-template"),
            'button.increment' => __('Increment', "wp-plugin-template"),
            'button.decrement' => __('Decrement', "wp-plugin-template"),
            'counter' => __("Counter", "wp-plugin-template")
        ];
    }
}