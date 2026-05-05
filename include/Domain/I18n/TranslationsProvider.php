<?php 

namespace PluginTemplate\Inc\Domain\I18n;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class TranslationsProvider extends AbstractSingleton
{
    public function get() : array 
    {
        return [
            'Hello from REACT' => __('❤️ Hello from REACT ❤️', 'wp-plugin-template'),
            'button.increment' => __('Increment', 'wp-plugin-template'),
            'button.decrement' => __('Decrement', 'wp-plugin-template'),
            'counter' => __("Counter", 'wp-plugin-template')
        ];
    }
}