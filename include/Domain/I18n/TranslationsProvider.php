<?php 

namespace PluginTemplate\Inc\Domain\I18n;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginConfig;

class TranslationsProvider
{
    public function get() : array 
    {
        $domain = PluginConfig::PLUGIN_DOMAIN;

        return [
            'hello.react' => __('❤️ Hello from REACT ❤️', $domain),
            'button.increment' => __('Increment', $domain),
            'button.decrement' => __('Decrement', $domain),
            'counter' => __("Counter", $domain)
        ];
    }
}