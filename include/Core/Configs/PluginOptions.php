<?php

namespace AstraToolbox\Inc\Core\Configs;

use AstraToolbox\Inc\Core\Enums\PluginOptionsEnum;

if (!defined('ABSPATH')) {
    exit;
}

class PluginOptions
{
    /**
     * Domyślne wartości opcji powiązane z OptionsEnum
     */
    private static array $defaults = [
        PluginOptionsEnum::CART_ICON_SVG => '
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                aria-hidden="true">
                <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2Zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2ZM7.2 14h9.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49a1 1 0 0 0-.87-1.48H6.21L5.27 2H2v2h2l3.6 7.59-1.35 2.44C5.52 15.37 6.48 17 8 17h12v-2H8l1.2-1Z"/>
            </svg>',
        PluginOptionsEnum::ACCOUNT_ICON_SVG => '
            <svg viewBox="0 0 360 360"
                    xmlns="http://www.w3.org/2000/svg"
                    class="ast-icon-account"
                    aria-hidden="true">
                <path d="M245,119c0,35.9-29.1,65-65,65s-65-29.1-65-65,29.1-65,65-65,65,29.1,65,65ZM302,270.8v-13.6c0-27-41.6-59.9-122-59.9s-122,32.9-122,59.9v13.6c0,19.5,15.8,35.2,35.2,35.2h173.6c19.4,0,35.2-15.8,35.2-35.2Z"
                        fill="currentColor"/>
            </svg>'
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
        $stored = get_option($option);

        if ($stored !== false) {
            return $stored;
        }

        if ($default !== null) {
            return $default;
        }

        return self::$defaults[$option] ?? null;
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
        update_option($option, $value);
    }

    /**
     * Usuwa opcję
     *
     * @param string $option Const z OptionsEnum
     * @return void
     */
    public static function delete(string $option): void
    {
        delete_option($option);
    }
}
