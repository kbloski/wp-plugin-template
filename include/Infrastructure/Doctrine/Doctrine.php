<?php

namespace PluginTemplate\Inc\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\Mysqli\Driver as MysqliDriver;
use Doctrine\DBAL\Connection;

class Doctrine
{
    private static ?EntityManager $em = null;

    public static function em(): EntityManager
    {
        if (self::$em === null) 
        {
            global $wpdb;

            // Ścieżka do encji
            $paths = [__DIR__ . '/../Domain/Entities'];
            $isDevMode = defined('WP_DEBUG') && WP_DEBUG;

            $config = ORMSetup::createAttributeMetadataConfiguration(
                $paths,
                $isDevMode
            );

            // Parametry połączenia DBAL używając mysqli
            $connectionParams = [
                'dbname'   => $wpdb->dbname,
                'user'     => $wpdb->dbuser,
                'password' => $wpdb->dbpassword,
                'host'     => $wpdb->dbhost,
                'driver'   => MysqliDriver::class,
                // 'charset'  => 'utf8mb4',
            ];

            // Tworzymy połączenie
            $connection = new Connection($connectionParams, new MysqliDriver(), new Configuration());

            // Tworzymy EntityManager
            self::$em = new EntityManager($connection, $config);
        }

        return self::$em;
    }
}
