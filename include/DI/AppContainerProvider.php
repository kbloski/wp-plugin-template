<?php

namespace PluginTemplate\Inc\DI;

use PluginTemplate\Inc\Adapters\Monolog\MonologLoggerAdapter;
use PluginTemplate\Inc\Adapters\WordPress\AdminMenuAdapter;
use PluginTemplate\Inc\Adapters\WordPress\AssetsAdapter;
use PluginTemplate\Inc\Adapters\WordPress\DatabaseAdapter;
use PluginTemplate\Inc\Adapters\WordPress\EnvironmentAdapter;
use PluginTemplate\Inc\Adapters\WordPress\EscaperAdapter;
use PluginTemplate\Inc\Adapters\WordPress\HooksAdapter;
use PluginTemplate\Inc\Adapters\WordPress\OptionsStoreAdapter;
use PluginTemplate\Inc\Adapters\WordPress\RestAdapter;
use PluginTemplate\Inc\Adapters\WordPress\ShortcodesAdapter;
use PluginTemplate\Inc\Adapters\WordPress\TranslatorAdapter;
use PluginTemplate\Inc\Adapters\WordPress\UsersAdapter;
use PluginTemplate\Inc\Domain\Interfaces\AdminMenuInterface;
use PluginTemplate\Inc\Domain\Interfaces\AssetsInterface;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;
use PluginTemplate\Inc\Domain\Interfaces\EnvironmentInterface;
use PluginTemplate\Inc\Domain\Interfaces\EscaperInterface;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;
use PluginTemplate\Inc\Domain\Interfaces\LoggerInterface;
use PluginTemplate\Inc\Domain\Interfaces\OptionsStoreInterface;
use PluginTemplate\Inc\Domain\Interfaces\RestInterface;
use PluginTemplate\Inc\Domain\Interfaces\ShortcodesInterface;
use PluginTemplate\Inc\Domain\Interfaces\TranslatorInterface;
use PluginTemplate\Inc\Domain\Interfaces\UsersInterface;
use PluginTemplate\Inc\Infrastructure\Installers\CapabilitiesInstaller;
use PluginTemplate\Inc\Infrastructure\Mappers\ExampleMapper;
use PluginTemplate\Inc\Infrastructure\Migrations;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use PluginTemplate\Inc\Presentation\Admin\AdminPages;
use PluginTemplate\Inc\Presentation\Injectors\ReactAssetsInjector;
use PluginTemplate\Inc\Presentation\Injectors\StylesInjector;
use PluginTemplate\Inc\Presentation\Injectors\VariablesInjector;

class AppContainerProvider
{
    public function register(Container $container): void
    {
        $this->registerAdapters($container);
        $this->registerInfrastructure($container);
        $this->registerPresentation($container);
    }

    /**
     * Wszystko, co zewnętrzne (WordPress, biblioteki z vendor), wchodzi przez port z Domain/Interfaces.
     * Podmiana adaptera = zmiana jednej linii tutaj.
     */
    private function registerAdapters(Container $container): void
    {
        $container->set(HooksInterface::class, fn() => new HooksAdapter());
        $container->set(ShortcodesInterface::class, fn() => new ShortcodesAdapter());
        $container->set(OptionsStoreInterface::class, fn() => new OptionsStoreAdapter());
        $container->set(DatabaseInterface::class, fn() => new DatabaseAdapter());
        $container->set(RestInterface::class, fn() => new RestAdapter());
        $container->set(AssetsInterface::class, fn() => new AssetsAdapter());
        $container->set(AdminMenuInterface::class, fn() => new AdminMenuAdapter());
        $container->set(UsersInterface::class, fn() => new UsersAdapter());
        $container->set(TranslatorInterface::class, fn() => new TranslatorAdapter());
        $container->set(EnvironmentInterface::class, fn() => new EnvironmentAdapter());
        $container->set(EscaperInterface::class, fn() => new EscaperAdapter());

        $container->set(LoggerInterface::class, fn(Container $container) => new MonologLoggerAdapter(
            $container->get(EnvironmentInterface::class)
        ));
    }

    private function registerInfrastructure(Container $container): void
    {
        $exampleMapper = new ExampleMapper();

        $container->set(ExampleRepository::class, function (Container $container) use ($exampleMapper) {
            return new ExampleRepository(
                db: $container->get(DatabaseInterface::class),
                exampleMapper: $exampleMapper
            );
        });

        $container->set(Migrations::class, fn(Container $container) => new Migrations(
            $container->get(DatabaseInterface::class)
        ));

        $container->set(CapabilitiesInstaller::class, fn(Container $container) => new CapabilitiesInstaller(
            $container->get(UsersInterface::class)
        ));
    }

    private function registerPresentation(Container $container): void
    {
        $container->set(AdminPages::class, fn(Container $container) => new AdminPages(
            $container->get(HooksInterface::class),
            $container->get(AdminMenuInterface::class),
            $container->get(AssetsInterface::class),
            $container->get(ShortcodesInterface::class)
        ));

        $container->set(ReactAssetsInjector::class, fn(Container $container) => new ReactAssetsInjector(
            $container->get(HooksInterface::class),
            $container->get(AssetsInterface::class),
            $container->get(ShortcodesInterface::class),
            $container->get(EscaperInterface::class)
        ));

        $container->set(StylesInjector::class, fn(Container $container) => new StylesInjector(
            $container->get(HooksInterface::class),
            $container->get(AssetsInterface::class)
        ));

        $container->set(VariablesInjector::class, fn(Container $container) => new VariablesInjector(
            $container->get(HooksInterface::class),
            $container->get(EscaperInterface::class),
            $container->get(TranslatorInterface::class)
        ));
    }
}
