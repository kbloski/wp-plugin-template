<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use Exception;
use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Entities\ExampleEntity;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Infrastructure\Doctrine\Doctrine;
use PluginTemplate\Inc\Infrastructure\Repositories\ExampleRepository;
use Throwable;

class DevTestShortcode extends AbstractsAbstractShortcode
{
    private ExampleRepository $exampleRepository;
    protected array $atts = [];

    protected function __construct()
    {
        $this->exampleRepository = ExampleRepository::getInstance();
    }

    public function getShortcodeName(): string
    {
        return ShortcodesNamesEnum::DEV_TEST();
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
