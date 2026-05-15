<?php 
namespace PluginTemplate\Inc\Presentation;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminDocumentationShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminSettingsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\ShortcodesDocsShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Admin\AdminHomeShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Counter\ApiCounterShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Counter\CounterShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\Counter\PageCounterShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\DevTestShortcode;
use PluginTemplate\Inc\Presentation\Shortcodes\HelloReactShortcode;

class Shortcodes
{
    /** @var string[] */
    private  array $shortcodesNames = [];

    public  function init()
    {
        (new AdminHomeShortcode())->register();
        (new AdminSettingsShortcode())->register();
        (new AdminDocumentationShortcode())->register();

        // Private 
        (new ShortcodesDocsShortcode())->register();

        // Public shortcodes with documentation
        $this->registerShortcode((new DevTestShortcode()));
        $this->registerShortcode((new HelloReactShortcode()));
        $this->registerShortcode((new CounterShortcode()));
        $this->registerShortcode((new PageCounterShortcode()));
        $this->registerShortcode((new ApiCounterShortcode()));
    }

    public  function getShortcodesDocumentation()
    {
        return $this->shortcodesNames;
    }

    private function registerShortcode( AbstractShortcode $instance )
    {
        $instance->register();
        $this->shortcodesNames[$instance->name()] = [
            "attributes" => $instance->getAttributes()
        ];
    }
}