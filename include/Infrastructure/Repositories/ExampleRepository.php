<?php 

namespace PluginTemplate\Inc\Infrastructure\Repositories;

use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;
use PluginTemplate\Inc\Domain\Models\Example;
use PluginTemplate\Inc\Infrastructure\Mappers\ExampleMapper;
use Throwable;

class ExampleRepository
{
    private readonly DatabaseInterface $db;
    private readonly ExampleMapper $exampleMapper;
    private readonly string $tableName;

    public function __construct( DatabaseInterface $db, ExampleMapper $exampleMapper)
    {
        $this->db = $db;
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

                $this->db->execute($sql, [
                    $i->id ?? 0,
                    $i->userId,
                    $i->message
                ]);

                if ($i->id === null)  $i->id = $this->db->lastInsertId();
                $upsertedItems[] = $i;
            }
        } catch (\Throwable $e) {
            Logger::error($e);
            throw $e;
        }

        return $upsertedItems;
    }

    /**
     * @return Example[]
     */
    public function getAll(): array
    {
        try {
            $rows = $this->db->select("SELECT * FROM {$this->tableName}");

            return array_map(fn($row) => $this->exampleMapper->mapFromDb($row), $rows);
        } catch (Throwable $e) {
            Logger::error($e);
            throw $e;
        }
    }
}
