<?php

namespace PluginTemplate\Inc\Adapters\Monolog;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger as MonologLogger;
use PluginTemplate\Inc\Core\Configs\PluginConfig;
use PluginTemplate\Inc\Domain\Interfaces\EnvironmentInterface;
use PluginTemplate\Inc\Domain\Interfaces\LoggerInterface;
use Throwable;

final class MonologLoggerAdapter implements LoggerInterface
{
    private ?MonologLogger $logger = null;

    public function __construct(private readonly EnvironmentInterface $environment)
    {
    }

    public function error(string|Throwable $message, array $context = []): void
    {
        if ($message instanceof Throwable) {
            $context['exception'] = $message;
            $message = $message->getMessage();
        }

        $this->getLogger()->error($message, $context);
    }

    private function getLogger(): MonologLogger
    {
        if ($this->logger === null) {
            $this->logger = new MonologLogger(PluginConfig::PLUGIN_SLUG);
            $this->logger->pushHandler(
                new StreamHandler($this->getLogFile(), Level::Debug)
            );
        }

        return $this->logger;
    }

    private function getLogFile(): string
    {
        $directory = $this->environment->contentPath('logs/' . PluginConfig::PLUGIN_PREFIX . 'logs');

        $this->environment->ensureDirectory($directory);

        return $directory . '/' . date('Y-m-d') . '.log';
    }
}
