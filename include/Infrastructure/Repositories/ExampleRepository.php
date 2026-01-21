<?php 

namespace PluginTemplate\Inc\Infrastructure\Repositories;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Entities\ExampleEntity;
use PluginTemplate\Inc\Infrastructure\Doctrine\Doctrine;
use Throwable;

class ExampleRepository extends AbstractSingleton
{
    /**
     * Upsert (insert lub update) wielu encji ExampleEntity.
     *
     * @param ExampleEntity[] $entities Tablica encji do wstawienia/aktualizacji
     * @return ExampleEntity[] Tablica zaktualizowanych lub nowo utworzonych encji
     * @throws \Throwable
     */
    public function upsertMany(array $entities): array
    {
        /** @var ExampleEntity[] $updatedEntities */
        $updatedEntities = [];

        try {
            $em = Doctrine::em();

            foreach ($entities as $entity) {
                $existingEntity = $em->find(ExampleEntity::class, $entity->id);

                if ($existingEntity) {
                    $existingEntity->counter = $entity->counter;
                    $e = $existingEntity;
                } else {
                    $e = $entity;
                }

                $em->persist($e);
                $updatedEntities[] = $e;
            }

            $em->flush();

        } catch (\Throwable $e) {
            Logger::error($e);
            throw $e;
        }

        return $updatedEntities;
    }


    public function getAll() : array 
    {
        try {
            return Doctrine::em()->getRepository(ExampleEntity::class)->findAll();
        } catch (Throwable $e)
        {
            Logger::error($e);
            throw $e;
        }
    }

    public function getById( int $id) : ?ExampleEntity
    {
        try {
            return Doctrine::em()->getRepository(ExampleEntity::class)->getById($id);
        } catch (Throwable $e)
        {
            Logger::error($e);
            throw $e;
        }
    }
}