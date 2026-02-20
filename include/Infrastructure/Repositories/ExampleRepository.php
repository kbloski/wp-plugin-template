<?php 

namespace PluginTemplate\Inc\Infrastructure\Repositories;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;
use PluginTemplate\Inc\Domain\Models\Example;
use Throwable;

class ExampleRepository extends AbstractSingleton
{
    private $tableName;

    protected function __construct()
    {
        $this->tableName = TableNamesEnum::EXAMPLE();
    }

    /**
     * Upsert (insert lub update) wielu encji Example.
     *
     * @param Example[] $entities Tablica encji do wstawienia/aktualizacji
     * @return Example[] Tablica zaktualizowanych lub nowo utworzonych encji
     * @throws \Throwable
     */
    public function upsertMany(array $entities): array
    {
        global $wpdb;

        /** @var Example[] $entities */
        $upsertedEntities = [];
        try {

            foreach ($entities as $entity) {
                $sql = "
                    INSERT INTO {$this->tableName} (id, counter)
                    VALUES (%d, %d)
                    ON DUPLICATE KEY UPDATE
                        counter = VALUES(counter)
                ";

                $prepared = $wpdb->prepare(
                    $sql,
                    $entity->id ?? 0,
                    $entity->counter,
                );

                $wpdb->query($prepared);

                if ($entity->id === null)  $entity->id = (int) $wpdb->insert_id;
                $upsertedEntities[] = $entity;
            }

        } catch (\Throwable $e) {
            Logger::error($e);
            throw $e;
        }

        return $upsertedEntities;
    }


    /**
     * Pobiera wszystkie rekordy z tabeli i zamienia je na Example
     * @return Example[]
     */
    public function getAll(): array
    {
        global $wpdb;
        try {
            $rows = $wpdb->get_results("SELECT * FROM {$this->tableName}", ARRAY_A);
            return array_map(fn($d) => Example::fromArray($d), $rows);
        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }

    /**
     * Pobiera pojedynczy rekord po ID i zamienia na ExampleEntity.
     *
     * @param int $id
     * @return Example|null
     */
    public function getById(int $id): ?Example
    {
        global $wpdb;

        try {
            $row = $wpdb->get_row(
                $wpdb->prepare("SELECT * FROM {$this->tableName} WHERE id = %d", $id),
                ARRAY_A
            );
            return empty($row) ? null : Example::fromArray($row);
        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }
}