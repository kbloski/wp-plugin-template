<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ReactRootsEnum;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Presentation\React\ReactRootRenderer;

class HelloReactShortcode extends AbstractsAbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::HELLO_REACT();
    }

    public function render_shortcode(array $atts = []): string
    {
        return ReactRootRenderer::renderRoot(ReactRootsEnum::HELLO_REACT());
    }

}
