<?php 

namespace PluginTemplate\Inc\Domain\Enums;

use PluginTemplate\Inc\Core\Naming\NameBuilder;

class UserMetaEnum
{
    private function __construct(){}

    public static function COUNTER() : string 
    {
        return NameBuilder::applySlug('counter');
    }
}