<?php 

namespace PluginTemplate\Inc\Infrastructure\Migrations;

use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;
use PluginTemplate\Inc\Domain\Interfaces\DatabaseInterface;
use Throwable;

class _20260522_CreateTables
{
    public function __construct(private readonly DatabaseInterface $db)
    {
    }

    public function execute() : void 
    {
        try 
        {
            $this->createExampleTable();
        } 
        catch (Throwable $e)
        {
            Logger::error( $e );
            throw $e;
        }
    }

    private function createExampleTable() : void 
    {
        $tableName = TableNamesEnum::EXAMPLE();
        $usersTable = TableNamesEnum::WP_USERS();
        $charsetCollate = $this->db->charsetCollate();

        $schema = [
            'id'         => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'user_id'    => "BIGINT(20) UNSIGNED NOT NULL",
            'message'    => 'TEXT NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ];

        $columns = [];
        foreach ($schema as $column => $definition) {
            $columns[] = "$column $definition";
        }

        // Dodajemy klucz obcy do wp_users
        $columns[] = "FOREIGN KEY (user_id) REFERENCES $usersTable(ID) ON DELETE CASCADE";

        $columns_sql = implode(",\n", $columns);

        $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            $columns_sql,
            PRIMARY KEY (id)
        ) $charsetCollate ENGINE=InnoDB;"; // InnoDB wymagany dla FK

        // Rzuca wyjątek, gdy baza zgłosi błąd
        $this->db->applySchema($sql);
    }
}
