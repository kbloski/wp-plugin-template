<?php 

namespace PluginTemplate\Inc\Infrastructure\Providers;

use PluginTemplate\Inc\Core\Container\Container;
use PluginTemplate\Inc\Infrastructure\Mappers\ExampleMapper;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;

class RepositoryProvider
{
    public function register(Container $container): void
    {
        $exampleMapper = new ExampleMapper();

        $container->set(ExampleRepository::class, function ($c) use ($exampleMapper)
        {
            return new ExampleRepository(
                exampleMapper: $exampleMapper
            );
        });
    }
}