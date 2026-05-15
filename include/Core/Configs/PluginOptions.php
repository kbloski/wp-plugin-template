<?php

namespace PluginTemplate\Inc\Core\Configs;

use PluginTemplate\Inc\Core\Enums\PluginOptionsEnum;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

if (!defined('ABSPATH')) {
    exit;
}

class PluginOptions extends PluginConfig
{
    /**
     * Domyślne wartości opcji powiązane z OptionsEnum
     */
    private static array $defaults = [
        self::PLUGIN_SLUG."option" => 'Default Value',
 
    ];

        /**
     * Pobiera wartość opcji
     *
     * @param string $option Const z OptionsEnum
     * @param mixed|null $default Wartość domyślna nadpisująca globalną
     * @return mixed
     */
    public static function get(string $option, $default = null)
    {
        $optionName = NameBuilder::applySlug($option);

        $stored = get_option(
            $optionName
        );

        if (!empty($stored))  return $stored;
        
        if (isset(self::$defaults[$option])) 
        {
            return self::$defaults[$option];
        }
        
        return $default;
    }

    /**
     * Ustawia wartość opcji
     *
     * @param string $option Const z OptionsEnum
     * @param mixed $value
     * @return void
     */
    public static function set(string $option, $value): void
    {
        $optionName = NameBuilder::applySlug($option);
        update_option($optionName, $value);
    }

    /**
     * Usuwa opcję
     *
     * @param string $option Const z OptionsEnum
     * @return void
     */
    public static function delete(string $option): void
    {
        $optionName = NameBuilder::applySlug($option);
        delete_option($optionName);
    }
}
