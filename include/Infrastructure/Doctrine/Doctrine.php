<?php

namespace LiveCard\Inc\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter; // cache w pamięci

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

            // Prosty cache w pamięci
            $cache = new ArrayAdapter();

            // Konfiguracja ORM bez 2nd-level cache
            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: $paths,
                isDevMode: $isDevMode,
                proxyDir: null,
                cache: $cache
            );
            $config->setSecondLevelCacheEnabled(false);

            // Parametry połączenia - podajemy tylko 'driver' jako string
            $connectionParams = [
                'dbname'   => $wpdb->dbname,
                'user'     => $wpdb->dbuser,
                'password' => $wpdb->dbpassword,
                'host'     => $wpdb->dbhost,
                'driver'   => 'mysqli', // <- tutaj zmiana
            ];

            // Tworzymy połączenie
            $connection = DriverManager::getConnection($connectionParams);

            // Tworzymy EntityManager
            self::$em = new EntityManager($connection, $config);
        }

        return self::$em;
    }
}
