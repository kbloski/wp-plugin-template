<?php

use PluginTemplate\Inc\Framework\Hooks\PluginLifecycleHooks;

if (!defined('ABSPATH')) exit;
require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

PluginLifecycleHooks::onUninstall();
