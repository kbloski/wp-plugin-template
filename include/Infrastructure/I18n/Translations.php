<?php 

namespace PluginTemplate\Inc\Infrastructure\I18n;

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\TranslatorInterface;

/**
 * Statyczna fasada na TranslatorInterface z kontenera.
 * Katalog tłumaczeń znajduje się w adapterze (Adapters/WordPress/TranslatorAdapter).
 */
class Translations
{

    public static function all() : array 
    {
        return self::translator()->all();
    }

    public static function get( string $key ) : string 
    {
        return self::translator()->get($key);
    }

    private static function translator(): TranslatorInterface
    {
        return AppContainer::get()->get(TranslatorInterface::class);
    }
}
