<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Configs\PluginPaths;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;

class DevTestShortcode extends AbstractsAbstractShortcode
{
    protected array $atts = [];

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::DEV_TEST();
    }

    public function enqueue_assets(): void
    {
        $handle = $this->getShortcodeName();

        $js = PluginPaths::getInstance()->getUrl('assets/Presentation/Shortcodes/DevTestShortcode/index.js');
        $js_path = PluginPaths::getInstance()->getPath('assets/Presentation/Shortcodes/DevTestShortcode/index.js');

        if (file_exists($js_path)) 
        {
            wp_enqueue_script($handle, $js, ['wp-element'], filemtime($js_path), true);
        }

        // $css = PluginPaths::getInstance()->getUrl('assets/Templates/Shortcodes/RegisterClientShortcode/index.css');
        // $css_path = PluginPaths::getInstance()->getPath('assets/Templates/Shortcodes/RegisterClientShortcode/index.css');

        // if (file_exists($css_path)) {
        //     wp_enqueue_style($handle . '-style', $css, [], filemtime($css_path));
        // }

    }


    public function render_shortcode(array $atts = []): string
    {
        ob_start();
        ?>

            <div style="padding: 1rem;">
                <hr/>
                <div>Developerski component testowy</div>
                <div id="my-react-app"></div>
                <hr/>
            </div>

        <?php
        return ob_get_clean();
    }

}
