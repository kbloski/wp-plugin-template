<?php

namespace LiveCard\Inc\Infrastructure\Doctrine;

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

            $paths = [__DIR__ . '/../Domain/Entities'];
            $isDevMode = defined('WP_DEBUG') && WP_DEBUG;

            // Tworzymy konfigurację ORM bez cache
            $config = ORMSetup::createAttributeMetadataConfiguration(
                $paths,
                $isDevMode,
                null, // proxy dir
                null  // brak cache
            );

            $connectionParams = [
                'dbname'   => $wpdb->dbname,
                'user'     => $wpdb->dbuser,
                'password' => $wpdb->dbpassword,
                'host'     => $wpdb->dbhost,
                'driver'   => MysqliDriver::class,
            ];

            $connection = new Connection($connectionParams, new MysqliDriver(), new Configuration());

            self::$em = new EntityManager($connection, $config);
        }

        return self::$em;
    }
}
