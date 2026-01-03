<?php

/*
Plugin Name: AstraToolbox
Plugin URI:
Description: Dodatki dla motywu astra
Version: 1.0
Author: Kamil Błoński
Author URI: -
*/

use AstraToolbox\Inc\Application\Application;
use AstraToolbox\Inc\Core\Configs\PluginPaths;
use AstraToolbox\Inc\Core\Core;
use AstraToolbox\Inc\Framework\Framework;
use AstraToolbox\Inc\Infrastructure\Infrastructure;

if (!defined('ABSPATH')) exit;
require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');

PluginPaths::getInstance()->init(__FILE__);

register_activation_hook(__FILE__, 'AstraToolbox\Inc\Framework\Hooks\PluginLifecycleHooks::onActivate');
register_deactivation_hook(__FILE__, 'AstraToolbox\Inc\Framework\Hooks\PluginLifecycleHooks::onDeactivate');

Core::getInstance()->init();
Infrastructure::getInstance()->init();
Application::getInstance()->init();
Framework::getInstance()->init();


