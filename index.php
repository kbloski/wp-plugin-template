<?php

/*
Plugin Name: Plugin Template
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
use PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks;
use PluginTemplate\Inc\Infrastructure\Infrastructure;
use PluginTemplate\Inc\Presentation\Presentation;

if (!defined('ABSPATH')) exit;
require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');
require_once __DIR__ . '/bootstrap.php';

PluginPaths::getInstance()->init(__FILE__);

// Activate plugin
register_activation_hook(__FILE__, fn() => PluginLifecycleHooks::onActivate() );
// Deactivate plugin
register_deactivation_hook(__FILE__, fn() => PluginLifecycleHooks::onDeactivate() );

// Translations 
add_action('plugins_loaded', function () {
    load_plugin_textdomain(
        "wp-plugin-template",
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});