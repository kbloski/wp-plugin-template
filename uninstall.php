<?php

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\DI\AppContainerProvider;
use PluginTemplate\Inc\DI\Container;
use PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks;

if (!defined('ABSPATH')) exit;
require_once __DIR__ . '/vendor/autoload.php';

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Sam kontener (bez bootstrap.php), żeby adaptery były dostępne przy odinstalowaniu.
$container = new Container();
(new AppContainerProvider())->register($container);
AppContainer::init( $container );

PluginLifecycleHooks::onUninstall();
