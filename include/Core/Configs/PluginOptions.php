<?php

namespace PluginTemplate\Inc\Core\Configs;

use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\OptionsStoreInterface;

class PluginOptions extends PluginConfig
{
    /**
     * Domyślne wartości opcji powiązane z OptionsEnum
     */
    private static array $defaults = [
        PluginOptionsEnum::MIGRATIONS_VERSION => 0,
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

        $stored = self::store()->get(
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
        self::store()->set($optionName, $value);
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
        self::store()->delete($optionName);
    }

    private static function store(): OptionsStoreInterface
    {
        return AppContainer::get()->get(OptionsStoreInterface::class);
    }
}
