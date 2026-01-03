<?php

namespace WooLoyalty\Inc\Database\Tables;

use Exception;
use PluginTemplate\Inc\Config\Config;
use PluginTemplate\Inc\Enums\TableNamesEnum;
use PluginTemplate\Inc\Utils\DbHelper;
use PluginTemplate\Inc\Utils\LoggerX;

class PageUrlMetaTable
{
    // Schemat tabeli meta
    private static array $schema = [
        'id'          => 'BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT',
        'page_url_id' => 'BIGINT(20) UNSIGNED NOT NULL',  // FK do page_urls.id
        'meta_key'    => 'VARCHAR(100) NOT NULL',
        'meta_value'  => 'LONGTEXT NULL',
        'created_at'  => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at'  => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    ];

    public static function create(): void
    {
        DbHelper::clearLastError();

        global $wpdb;
        $table_name = TableNamesEnum::PAGE_URL_META();  // nowa nazwa w Enum
        $charset_collate = $wpdb->get_charset_collate();

        $columns = [];
        foreach (self::$schema as $column => $definition) {
            $columns[] = "$column $definition";
        }

        $columns_sql = implode(",\n", $columns);

        // Tworzymy tabelę z kluczem obcym do page_urls
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            $columns_sql,
            PRIMARY KEY (id),
            KEY page_url_id_idx (page_url_id),
            FOREIGN KEY (page_url_id) REFERENCES " . TableNamesEnum::PAGE_URLS() . "(id) ON DELETE CASCADE
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
        $table_name = TableNamesEnum::PAGE_URL_META();
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
