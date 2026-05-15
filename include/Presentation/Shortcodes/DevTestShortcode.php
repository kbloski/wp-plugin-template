<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode;
use PluginTemplate\Inc\Domain\Enums\ShortcodeNamesEnum;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use Exception;
use Throwable;

class DevTestShortcode extends AbstractShortcode
{

    public function __construct()
    {
    }

    public function name(): string
    {
        return ShortcodeNamesEnum::DEV_TEST;
    }

    public function enqueue_assets(): void
    {
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
