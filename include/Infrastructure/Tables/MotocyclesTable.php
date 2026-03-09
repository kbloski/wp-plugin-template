<?php

namespace PluginTemplate\Inc\Infrastructure\Tables;

use Exception;
use PluginTemplate\Inc\Core\Database\DbHelper;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Abstracts\AbstractTable;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;
use Throwable;

class MotocyclesTable
{
    protected string $tableName;

    protected function __construct()
    {
        $this->tableName = TableNamesEnum::EXAMPLE();
    }

    public function create(): void
    {
        try {

            // Schemat tabeli
            $schema = [
                'id'         => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
                'license_plate'    => 'INT(12) NOT NULL',
                'brand' => 'VARCHAR(32) NOT NULL',
                'color' => 'VARCHAR(64)',
                'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            ];

            DbHelper::clearError();

            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();

            $columns = [];
            foreach ($schema as $column => $definition) {
                $columns[] = "$column $definition";
            }

            $columns_sql = implode(",\n", $columns);

            $sql = "CREATE TABLE IF NOT EXISTS $this->tableName (
                $columns_sql,
                PRIMARY KEY (id)
            ) $charset_collate;";

            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($sql);

            if (DbHelper::hasError()) {
                $err = DbHelper::popError();
                Logger::error($err);
                throw new Exception($err);
            }
        } catch (Throwable $e) {
            Logger::error($e->getMessage());
            throw $e;
        }
    }

    public function drop(): void
    {
        try {
            DbHelper::clearError();

            global $wpdb;
            $sql = "DROP TABLE IF EXISTS $this->tableName";
            $wpdb->query($sql);

            if (DbHelper::hasError()) {
                $err = DbHelper::popError();
                Logger::error($err);
                throw new Exception($err);
            }
        } catch (Throwable $e) {
            Logger::error($e->getMessage());
            throw $e;
        }
    }
}
