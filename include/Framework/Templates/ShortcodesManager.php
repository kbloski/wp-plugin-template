<?php 
namespace AstraToolbox\Inc\Templates;

use AstraToolbox\Inc\Abstracts\AbstractSingleton;
use AstraToolbox\Inc\Templates\Shortcodes\AdminDocumentationShortcode;
use AstraToolbox\Inc\Templates\Shortcodes\AdminSettingsPageStylesShortcodes;
use AstraToolbox\Inc\Templates\Shortcodes\AdminSettingsShortcode;
use AstraToolbox\Inc\Templates\Shortcodes\DevTestShortcode;

class ShortcodesManager extends AbstractSingleton
{
    /** @var string[] */
    private  array $shortcodesNames = [];

    public  function init()
    {
        // Admin shortcodes
        AdminSettingsPageStylesShortcodes::getInstance()->register();
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