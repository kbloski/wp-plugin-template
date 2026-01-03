<?php 

namespace AstraToolbox\Inc\Templates\Admin;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Config\Config;
use AstraToolbox\Inc\Enums\CapabilityEnum;
use AstraToolbox\Inc\Enums\ShortcodesNamesEnum;

class AdminTemplate extends AbstractSingleton
{
    private function createSlug( string $slug )
    {
        return Config::PLUGIN_PREFIX.$slug;
    }

    public function init()
    {
        // add_action('admin_menu', function() {
        // // Dodajemy nową stronę w menu admina
        //     add_menu_page(
        //         'Moja Strona',           // Tytuł strony
        //         'Moje Menu',             // Nazwa w menu
        //         'manage_options',        // Uprawnienia
        //         'moja-strona-slug',      // Slug strony
        //         'moja_strona_callback',  // Funkcja wyświetlająca zawartość
        //         'dashicons-admin-generic', // Ikona menu
        //         66                       // Pozycja w menu
        //     );
        // });

            

        add_action('admin_menu', function () 
        {
            $mainPageSlug = $this->createSlug('home');

            add_menu_page(
                Config::PLUGIN_NAME,       
                Config::PLUGIN_NAME,       
                CapabilityEnum::PLUGIN_ACCESS(),
                $mainPageSlug,        
                function(){

                },
                'dashicons-art',           
                66                        
            );


            add_submenu_page(
                $mainPageSlug,
                'Ustawienia stylów stron',
                'Ustawienia stylów stron',
                CapabilityEnum::PLUGIN_ACCESS(),            
                $this->createSlug("settings-pages-styles"),                //  Slug page
                function()
                {
                    echo do_shortcode('['.ShortcodesNamesEnum::ADMIN_SETTINGS_PAGES_STYLES().']');
                }
            );

            add_submenu_page(
                $mainPageSlug,
                'Ustawienia',
                'Ustawienia',
                CapabilityEnum::PLUGIN_ACCESS(),            
                $this->createSlug("settings"),                //  Slug page
                function()
                {
                    echo do_shortcode('['.ShortcodesNamesEnum::ADMIN_SETTINGS().']');
                }
            );


            add_submenu_page(
                $mainPageSlug,
                'Dokumentacja',
                'Dokumentacja',
                CapabilityEnum::PLUGIN_ACCESS(),            
                $this->createSlug("documentation"),                //  Slug page
               function()
               {
                    echo do_shortcode('['.ShortcodesNamesEnum::ADMIN_DOCUMENTATION().']'); 
               }
            );
    
        });
    }


 



}