<?php

namespace AstraToolbox\Inc\Database\Tables;

use Exception;
use AstraToolbox\Inc\Config\Config;
use AstraToolbox\Inc\Enums\TableNamesEnum;
use AstraToolbox\Inc\Utils\DbHelper;
use AstraToolbox\Inc\Utils\LoggerX;

class PageUrlsTable
{
    // Schemat tabeli
    private static array $schema = [
        'id'         => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT', 
        'url'        => 'VARCHAR(255) NOT NULL',  
        'slug'       => 'VARCHAR(255) DEFAULT NULL', 
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',  
        'updated_at'  => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    ];

    public static function create(): void
    {
        DbHelper::clearLastError();

        global $wpdb;
        $table_name = TableNamesEnum::PAGE_URLS();  // nazwa tabeli w Enum
        $charset_collate = $wpdb->get_charset_collate();

        $columns = [];
        foreach (self::$schema as $column => $definition) {
            $columns[] = "$column $definition";
        }

        $columns_sql = implode(",\n", $columns);

        // Tworzymy tabelę, jeśli nie istnieje
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            $columns_sql,
            PRIMARY KEY (id),
            UNIQUE KEY url_unique (url)
        ) $charset_collate;";

        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        $result = dbDelta($sql);

        if (DbHelper::hasLastError()) {
            $errMessage = DbHelper::popLastError();
            LoggerX::error($errMessage);
            throw new Exception($errMessage);
        }
    }

    public static function drop(): void
    {
        DbHelper::clearLastError();

        global $wpdb;
        $table_name = TableNamesEnum::PAGE_URLS();
        $sql = "DROP TABLE IF EXISTS $table_name";

        $wpdb->query($sql);

        if (DbHelper::hasLastError()) {
            $errMessage = DbHelper::popLastError();
            LoggerX::error($errMessage);
            throw new Exception($errMessage);
        }
    }

    public static function getSchema(): array
    {
        return self::$schema;
    }
}
