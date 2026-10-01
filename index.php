<?php

/*
Plugin Name: Plugin Template
Plugin URI:
Description: Bazowy template pluginu
Version: 1.0
Author: Kamil Błoński
Author URI: -
*/

use PluginTemplate\Inc\DI\AppContainer;
use PluginTemplate\Inc\Domain\Interfaces\HooksInterface;
use PluginTemplate\Inc\Domain\Interfaces\TranslatorInterface;
use PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks;

if (!defined('ABSPATH')) exit;
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/bootstrap.php';

// Activate plugin
AppContainer::get()->get(HooksInterface::class)->onActivation(__FILE__, fn() => PluginLifecycleHooks::onActivate() );
// Deactivate plugin
AppContainer::get()->get(HooksInterface::class)->onDeactivation(__FILE__, fn() => PluginLifecycleHooks::onDeactivate() );

// Translations 
AppContainer::get()->get(TranslatorInterface::class)->loadTextDomain(__FILE__);
