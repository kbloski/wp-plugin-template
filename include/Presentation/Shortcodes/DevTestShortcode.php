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
        // Tutaj możesz dodać np. enqueue JS/CSS jeśli potrzebne
    }

    public function render_shortcode(array $atts = []): string
    {
        try {
            $e = new ExampleEntity(301);
            $e->id = 1;
            $this->exampleRepository->upsertMany([$e]);
    
            ob_start();
            ?>
            <div>
                Developerski component testowy
                <br>
                <pre>
                    <?= json_encode($this->exampleRepository->getAll(), JSON_PRETTY_PRINT) ?>
                </pre>
            </div>
            <?php
            return ob_get_clean();
        } catch (Throwable $e)
        {
            Logger::error($e);
            throw $e;
        }
    }
}
