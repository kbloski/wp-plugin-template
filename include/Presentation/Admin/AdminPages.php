<?php 

namespace PluginTemplate\Inc\Presentation\Admin;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Core\Enums\PluginCapabilitiesEnum;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class AdminPages extends AbstractSingleton
{
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
            $mainPageSlug = NameBuilder::applySlug('home');

            add_menu_page(
                PluginConfig::PLUGIN_NAME,       
                PluginConfig::PLUGIN_NAME,       
                PluginCapabilitiesEnum::PLUGIN_ACCESS(),
                $mainPageSlug,        
                function(){
                    echo do_shortcode('['.ShortcodesNamesEnum::ADMIN_HOME().']');
                },
                'dashicons-art',           
                66                        
            );

            add_submenu_page(
                $mainPageSlug,
                'Ustawienia',
                'Ustawienia',
                PluginCapabilitiesEnum::PLUGIN_ACCESS(),            
                NameBuilder::applySlug("settings"),                //  Slug page
                function()
                {
                    echo do_shortcode('['.ShortcodesNamesEnum::ADMIN_SETTINGS().']');
                }
            );


            add_submenu_page(
                $mainPageSlug,
                'Dokumentacja',
                'Dokumentacja',
                PluginCapabilitiesEnum::PLUGIN_ACCESS(),            
                NameBuilder::applySlug("documentation"),                //  Slug page
               function()
               {
                    echo do_shortcode('['.ShortcodesNamesEnum::ADMIN_DOCUMENTATION().']'); 
               }
            );
    
        });
    }


 



}