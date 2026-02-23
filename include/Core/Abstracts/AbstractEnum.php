<?php 

namespace PluginTemplate\Inc\Core\Abstracts;

use LogicException;

/**
 * Abstrakcyjna klasa dla shortcode'ów
 */
abstract class AbstractEnum
{
    /**
     * Konstruktor zablokowany, bo klasa jest abstrakcyjna
     */
    final protected function __construct()
    {
        throw new LogicException('AbstractShortcode cannot be instantiated directly');
    }
}
