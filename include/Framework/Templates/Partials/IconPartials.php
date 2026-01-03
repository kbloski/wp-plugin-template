<?php 

namespace AstraToolbox\Inc\Templates\Partials;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Config\Options;
use AstraToolbox\Inc\Enums\OptionsEnum;

class IconPartials extends AbstractSingleton
{
    public function register()
    {
        if (!empty(Options::get(OptionsEnum::OVERRIDE_ACCOUNT_SVG_ENABLED)))
        {
            $this->accountIcon();
        }

        if (!empty(Options::get(OptionsEnum::OVERRIDE_CART_SVG_ENABLED)))
        {
            $this->cartIcon();
        }
    }

    public function accountIcon()
    {
        add_filter('astra_svg_icons', function($icons) {
            $icons['account-1'] = Options::get(OptionsEnum::ACCOUNT_ICON_SVG);
            return $icons;
        });
    }
    
    public function cartIcon() {
        add_filter( 'astra_svg_icon',function($svg, $icon){

            if ( 'cart' === $icon ) {
                $svg = Options::get(OptionsEnum::CART_ICON_SVG);
            }
            
            return $svg;
        }, 10, 2 );
    }

}