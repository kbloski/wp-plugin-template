<?php

namespace PluginTemplate\Inc\Presentation\Shortcodes;

use PluginTemplate\Inc\Core\Abstracts\AbstractShortcode as AbstractsAbstractShortcode;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Entities\ExampleEntity;
use PluginTemplate\Inc\Domain\Enums\ShortcodesNamesEnum;
use PluginTemplate\Inc\Infrastructure\Doctrine\Doctrine;

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
        // 1️⃣ Tworzymy nową encję
        $example = new ExampleEntity();
        $example->setCounter(5);

        // 2️⃣ Pobieramy EntityManager
        $em = Doctrine::em();

        // 3️⃣ Persist + flush do bazy
        try {
            $em->persist($example);
            $em->flush();
        } catch (\Exception $e) {
            // Obsługa błędów – np. log do debug.log WordPress
            Logger::error('_');
            error_log('Błąd zapisu encji: ' . $e->getMessage());
            Logger::error('_');
        }

        // 4️⃣ Wyświetlamy HTML shortcode
        ob_start();
        ?>
        <div>
            Developerski component testowy
            <br>
            Encja zapisana z ID: <?php echo $example->getId(); ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
