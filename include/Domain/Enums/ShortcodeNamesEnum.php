<?php

namespace PluginTemplate\Inc\Domain\Enums;

use PluginTemplate\Inc\Core\Configs\PluginConfig;

final class ShortcodeNamesEnum extends PluginConfig
{
    public const ADMIN_HOME = self::PLUGIN_PREFIX."admin-home";
    public const ADMIN_SETTINGS = self::PLUGIN_PREFIX."admin-settings";
    public const ADMIN_DOCUMENTATION = self::PLUGIN_PREFIX."admin-documentatio";
    public const SHORTCODES_DOCS = self::PLUGIN_PREFIX."shortcodes-docs";
    public const DEV_TEST = self::PLUGIN_PREFIX."dev-test";
    public const HELLO_REACT = self::PLUGIN_PREFIX."hello-react";
    public const API_COUNTER = self::PLUGIN_PREFIX."api-counter";
    public const COUNTER = self::PLUGIN_PREFIX."counter";
    public const PAGE_COUNTER = self::PLUGIN_PREFIX."page-counter";
}
