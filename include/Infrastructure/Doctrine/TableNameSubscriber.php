<?php

namespace PluginTemplate\Inc\Infrastructure\Doctrine;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use PluginTemplate\Inc\Domain\Entities\ExampleEntity;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;

class TableNameSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [Events::loadClassMetadata];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
    {
        $metadata = $args->getClassMetadata();

        if ($metadata->getName() === ExampleEntity::class) {
            $metadata->setPrimaryTable([
                'name' => TableNamesEnum::EXAMPLE(), // TU możesz użyć metody
            ]);
        }
    }
}
