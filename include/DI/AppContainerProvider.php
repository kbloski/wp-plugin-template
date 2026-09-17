<?php

namespace PluginTemplate\Inc\DI;

use PluginTemplate\Inc\Infrastructure\Mappers\ExampleMapper;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;

class AppContainerProvider
{
    public function register(Container $container): void
    {
        $exampleMapper = new ExampleMapper();

        $container->set(ExampleRepository::class, function (Container $container) use ($exampleMapper) {
            return new ExampleRepository(
                exampleMapper: $exampleMapper
            );
        });
    }
}
