<?php 
namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\Shortcodes\AdminDocumentationShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\AdminSettingsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\DevTestShortcode;

class Shortcodes extends AbstractSingleton
{
    /** @var string[] */
    private  array $shortcodesNames = [];

    public  function init()
    {
        // Admin shortcodes
        AdminSettingsShortcode::getInstance()->register();
        AdminDocumentationShortcode::getInstance()->register();

        
        // Public shortcodes with documentation
        $this->registerShortcode(DevTestShortcode::getInstance());
    }

    
    public  function getShortcodesDocumentation()
    {
        return $this->shortcodesNames;
    }

    private function registerShortcode( $instance)
    {
        $instance->register();
        $this->shortcodesNames[$instance->getShortcodeName()] = [
            "attributes" => $instance->getAttributes()
        ];
    }
}