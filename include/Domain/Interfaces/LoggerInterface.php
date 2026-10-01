<?php

namespace PluginTemplate\Inc\Domain\Interfaces;

use Throwable;

/**
 * Port na logowanie.
 */
interface LoggerInterface
{
    public function error(string|Throwable $message, array $context = []): void;
}
