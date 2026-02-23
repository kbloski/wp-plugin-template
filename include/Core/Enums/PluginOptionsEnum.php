<?php

namespace PluginTemplate\Inc\Core\Enums;

use PluginTemplate\Inc\Core\Abstracts\AbstractEnum;

class PluginOptionsEnum extends AbstractEnum
{
    public const CART_ICON_SVG = "cart_icon_svg";
    public const ACCOUNT_ICON_SVG = 'account_icon_svg';
    public const REDIRECT_HOME_TO_LAST_PRODUCT = 'redirect_home_to_last_product'; 
    public const HOME_PAGE_REDIRECT_URL = 'home_page_redirect_url';
    public const PROMO_BAR_TEXT = 'promo_bar_text';
    public const PROMO_BAR_IS_VISIBLE = 'promo_bar_visible';
    public const BILLING_DEFAULTS = 'billing_defaults';
    public const ENABLE_AUTOFILL_BILLING_DEFAULTS = 'enable_autofill_billing_defaults';
    public const BILLING_FIELDS_VISIBILITY = 'billing_fields_visibility';


    public const OVERRIDE_CART_SVG_ENABLED = 'override_cart_svg_enabled';
    public const OVERRIDE_ACCOUNT_SVG_ENABLED = 'override_account_svg_enabled';
}
