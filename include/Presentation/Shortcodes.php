<?php 
namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Presentation\Shortcodes\Admin\EndpointsDocsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminDocumentationShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminSettingsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\ShortcodesDocsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\DevTestShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\HelloReactShortcode;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;

class Shortcodes extends AbstractSingleton
{
    /** @var string[] */
    private  array $shortcodesNames = [];

    public  function init()
    {
        // Admin shortcodes
        AdminSettingsShortcode::getInstance()->register();
        AdminDocumentationShortcode::getInstance()->register();

        // Private 
        ShortcodesDocsShortcode::getInstance()->register();
        EndpointsDocsShortcode::getInstance()->register();
        
        // Public shortcodes with documentation
        $this->registerShortcode(DevTestShortcode::getInstance());
        $this->registerShortcode(HelloReactShortcode::getInstance());
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