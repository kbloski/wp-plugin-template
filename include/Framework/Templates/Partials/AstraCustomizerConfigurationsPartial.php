<?php

namespace AstraToolbox\Inc\Templates\Partials;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Config\Config;
use AstraToolbox\Inc\Config\Options;
use AstraToolbox\Inc\Enums\OptionsEnum;
use AstraToolbox\Inc\Utils\LoggerX;
use Throwable;

class AstraCustomizerConfigurationsPartial extends AbstractSingleton
{
    private string $sectionName;
    private array $fieldsNames;

    protected function __construct()
    {
        $this->sectionName = Config::PLUGIN_SLUG . 'section';
        $this->fieldsNames = [
            'is_override_cart_svg' => Config::PLUGIN_SLUG . 'is_override_cart_svg',
            'is_override_account_svg' => Config::PLUGIN_SLUG . 'is_override_account_svg',
        ];
    }

    public function register()
    {
        $this->astraCustomizerConfigurations();

        // Hook wywoływany po zapisaniu Customizera
        add_action('customize_save_after', function () {
            $this->saveSettings();
        });
    }

    /**
     * Rejestracja sekcji i pola w Customizerze
     */
    public function astraCustomizerConfigurations()
    {
        add_filter('astra_customizer_configurations', function ($configurations, $wp_customize)
        {
            // Tworzymy własną sekcję
            $configurations[] = [
                'name'     => $this->sectionName,
                'type'     => 'section',
                'title'    => Config::PLUGIN_NAME,
                'panel'    => '', // pusty = nie w panelu Astry
                'priority' => 160,
            ];

            // Checkbox
            $configurations[] = [
                'name'     => $this->fieldsNames['is_override_cart_svg'],
                'type'     => 'control',
                'control'  => 'checkbox',
                'section'  => $this->sectionName,
                'title'    => __('Nadpisz SVG cart', 'my-plugin'),
                'default'  => $this->isOverrideCartSvg() ? 1 : 0,
                'sanitize' => function ($value) {
                    return !empty($value) ? 1 : 0;
                },
                'priority' => 10,
            ];

            $configurations[] = [
                'name'     => $this->fieldsNames['is_override_account_svg'],
                'type'     => 'control',
                'control'  => 'checkbox',
                'section'  => $this->sectionName,
                'title'    => __('Nadpisz SVG account-1', 'my-plugin'),
                'default'  => $this->isOverrideAccountSvg() ? 1 : 0,
                'sanitize' => function ($value) {
                    return !empty($value) ? 1 : 0;
                },
                'priority' => 10,
            ];

            return $configurations;

        }, 10, 2);
    }

    /**
     * Pobierz wartość checkboxa z własnej opcji DB
     */
    public function isOverrideCartSvg(): bool
    {
        $value = Options::get(OptionsEnum::OVERRIDE_CART_SVG_ENABLED, 0);
        return !empty($value);
    }

    /**
     * Pobierz wartość checkboxa z własnej opcji DB
     */
    public function isOverrideAccountSvg(): bool
    {
        $value = Options::get(OptionsEnum::OVERRIDE_ACCOUNT_SVG_ENABLED, 0);
        return !empty($value);
    }

    /**
     * Zapisz wartość checkboxa w własnej opcji DB po kliknięciu "Opublikuj"
     */
    public function saveSettings(): void
    {
        try {
            // Pobranie wartości z POST w momencie zapisu Customizera
            if (isset($_POST['customized'])) {
                $customized = json_decode(stripslashes($_POST['customized']), true);

                if (isset($customized[$this->fieldsNames['is_override_cart_svg']])) {
                    
                    $value = !empty($customized[$this->fieldsNames['is_override_cart_svg']]) ? 1 : 0;
                    Options::set(OptionsEnum::OVERRIDE_CART_SVG_ENABLED, $value);
                }


                if (isset($customized[$this->fieldsNames['is_override_account_svg']])) {
                    
                    $value = !empty($customized[$this->fieldsNames['is_override_account_svg']]) ? 1 : 0;
                    Options::set(OptionsEnum::OVERRIDE_ACCOUNT_SVG_ENABLED, $value);
                }
            }


        } catch (Throwable $e) {
            LoggerX::error($e->getMessage());
        }
    }
}
