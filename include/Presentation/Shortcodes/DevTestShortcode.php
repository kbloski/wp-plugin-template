<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use Exception;
use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Entities\ExampleEntity;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Infrastructure\Doctrine\Doctrine;
use Throwable;

class DevTestShortcode extends AbstractsAbstractShortcode
{
    protected array $atts = [];

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
            throw new Exception("test");

            // 1️⃣ Tworzymy nową encję
            // if (false)
            // {
            //     $example = new ExampleEntity();
            //     $example->counter = 10;
            //     $em->persist($example);
            //     $em->flush();
            // }
    
            // 4️⃣ Wyświetlamy HTML shortcode
            ob_start();
            ?>
            <div>
                Developerski component testowy
                <br>
                <!--  var_dump(Doctrine::em()->find(ExampleEntity::class, 1)) ?> -->
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
