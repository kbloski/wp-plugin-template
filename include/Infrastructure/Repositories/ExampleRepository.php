<?php 

namespace PluginTemplate\Inc\Infrastructure\Repositories;

use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;
use PluginTemplate\Inc\Domain\Models\Example;
use PluginTemplate\Inc\Infrastructure\Mappers\ExampleMapper;
use Throwable;

class ExampleRepository
{
    private readonly ExampleMapper $exampleMapper;
    private readonly string $tableName;

    public function __construct( ExampleMapper $exampleMapper)
    {
        $this->tableName = TableNamesEnum::EXAMPLE();
        $this->exampleMapper = $exampleMapper;
    }

    /**
     * @param Example[] 
     * @return Example[] 
     * @throws Throwable
     */
    public function upsertMany(array $items): array
    {
        global $wpdb;

        /** @var Example[] $item */
        $upsertedItems = [];
        try {

            foreach ($items as $i) {
                $sql = "
                    INSERT INTO {$this->tableName} (id, user_id, message)
                    VALUES (%d, %d, %s)
                    ON DUPLICATE KEY UPDATE
                        user_id = VALUES(user_id),
                        message = VALUES(message)
                ";

                $prepared = $wpdb->prepare(
                    $sql,
                    $i->id ?? 0,
                    $i->userId,
                    $i->message
                );

                $wpdb->query($prepared);

                if ($i->id === null)  $i->id = (int) $wpdb->insert_id;
                $upsertedItems[] = $i;
            }
        } catch (\Throwable $e) {
            Logger::error($e);
            throw $e;
        }

        return $upsertedItems;
    }

    /**
     * @param int $id
     * @return Example[]
     */
    public function getAll(): array
    {
        global $wpdb;

        try {
            $rows = $wpdb->get_results(
                $wpdb->prepare("SELECT * FROM {$this->tableName}"),
                ARRAY_A
            );

            return array_map(fn($row) => $this->exampleMapper->mapFromDb($row), $rows);
        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }
}