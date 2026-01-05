<?php

/*
Plugin Name: WP Plugin Template
Plugin URI:
Description: Bazowy template pluginu
Version: 1.0
Author: Kamil Błoński
Author URI: -
*/

use PluginTemplate\Inc\Application\Application;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Core\Core;
use PluginTemplate\Inc\Framework\Framework;
use PluginTemplate\Inc\Infrastructure\Infrastructure;
use PluginTemplate\Inc\Presentation\Presentation;

if (!defined('ABSPATH')) exit;
require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');

PluginPaths::getInstance()->init(__FILE__);

// Activate plugin
register_activation_hook(__FILE__, 'PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks::onActivate');
// Deactivate plugin
register_deactivation_hook(__FILE__, 'PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks::onDeactivate');

Core::getInstance()->init();
Infrastructure::getInstance()->init();
Application::getInstance()->init();
Presentation::getInstance()->init();
Framework::getInstance()->init();


