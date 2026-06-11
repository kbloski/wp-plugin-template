<?php 

namespace PluginTemplate\Inc\Infrastructure\Migrations;

use Exception;
use PluginTemplate\Inc\Core\Database\DbHelper;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Core\Naming\NameBuilder;
use Throwable;

class _20260522_CreateTables
{
    public function __construct()
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
        global $wpdb;
        $tableName = $wpdb->prefix . NameBuilder::applySlug("example");
        $usersTable = $wpdb->prefix . 'users';
        $charsetCollate = $wpdb->get_charset_collate();

        $schema = [
            'id'         => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
            'user_id'    => "BIGINT(20) UNSIGNED NOT NULL",
            'message'    => 'TEXT NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ];

        DbHelper::clearError();

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

        require_once(ABSPATH . "wp-admin/includes/upgrade.php");

        dbDelta($sql);

        if (DbHelper::hasError()) {
            $err = DbHelper::popError();
            throw new Exception($err);
        }

    }
}