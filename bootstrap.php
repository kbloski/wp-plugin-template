<?php

use PluginTemplate\Inc\Application\Application;
use PluginTemplate\Inc\Core\Container\ContainerRegistry;
use PluginTemplate\Inc\Core\Core;
use PluginTemplate\Inc\Core\Container\Container;
use PluginTemplate\Inc\Framework\Framework;
use PluginTemplate\Inc\Infrastructure\Infrastructure;
use PluginTemplate\Inc\Infrastructure\Providers\RepositoryProvider;
use PluginTemplate\Inc\Presentation\Presentation;

(new Core())->init();
(new Infrastructure())->init();
(new Application())->init();
(new Presentation())->init();
(new Framework)->init();

$container = new Container();

(new RepositoryProvider())->register($container);

ContainerRegistry::init( $container );
