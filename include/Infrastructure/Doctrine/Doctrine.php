<?php

namespace PluginTemplate\Inc\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\Common\EventManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

use PluginTemplate\Inc\Infrastructure\Doctrine\TableNameSubscriber;

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

            $cache = new ArrayAdapter();

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: $paths,
                isDevMode: $isDevMode,
                proxyDir: null,
                cache: $cache
            );

            $config->setSecondLevelCacheEnabled(false);

            $connectionParams = [
                'dbname'   => $wpdb->dbname,
                'user'     => $wpdb->dbuser,
                'password' => $wpdb->dbpassword,
                'host'     => $wpdb->dbhost,
                'driver'   => 'mysqli',
            ];

            $connection = DriverManager::getConnection($connectionParams);

            // ⬇️ TO JEST KLUCZOWE
            $eventManager = new EventManager();
            $eventManager->addEventSubscriber(new TableNameSubscriber());

            // ⬇️ PRZEKAZUJEMY EventManager
            self::$em = new EntityManager($connection, $config, $eventManager);
        }

        return self::$em;
    }
}
