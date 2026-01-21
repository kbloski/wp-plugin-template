<?php

namespace PluginTemplate\Inc\Domain\Enums;

use PluginTemplate\Inc\Core\Abstracts\AbstractEnum;
use PluginTemplate\Inc\Core\Naming\NameBuilder;

final class ReactRootsEnum extends AbstractEnum
{
    public static function HELLO_REACT() : string 
    {
        return NameBuilder::applyPrefix('hello-react');
    }
}
