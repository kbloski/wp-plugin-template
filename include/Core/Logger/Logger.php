<?php

namespace PluginTemplate\Inc\Core\Logger;

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\LoggerInterface;
use Throwable;

/**
 * Statyczna fasada na LoggerInterface z kontenera.
 */
class Logger
{
    public static function error(string|Throwable $message, array $context = []): void
    {
        AppContainer::get()->get(LoggerInterface::class)->error($message, $context);
    }
}
