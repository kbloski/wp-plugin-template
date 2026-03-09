<?php 
namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\EndpointsDocsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminDocumentationShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminSettingsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\ShortcodesDocsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminHomeShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Counter\CounterShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Counter\GlobalCounterShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\DevTestShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\React\GlobalReactStoreShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\HelloReactShortcode;

class Shortcodes extends AbstractSingleton
{
    /** @var string[] */
    private  array $shortcodesNames = [];

    public  function init()
    {
        // Admin shortcodes
        AdminHomeShortcode::getInstance()->register();
        AdminSettingsShortcode::getInstance()->register();
        AdminDocumentationShortcode::getInstance()->register();

        // Private 
        ShortcodesDocsShortcode::getInstance()->register();
        EndpointsDocsShortcode::getInstance()->register();
        
        // Public shortcodes with documentation
        $this->registerShortcode( DevTestShortcode::getInstance() );
        $this->registerShortcode( HelloReactShortcode::getInstance() );
        $this->registerShortcode( CounterShortcode::getInstance() );
        $this->registerShortcode( GlobalCounterShortcode::getInstance() );
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