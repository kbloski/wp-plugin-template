<?php

namespace PluginTemplate\Inc\Infrastructure;

use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Infrastructure\Tables\ExampleTable;
use Throwable;

class Tables 
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function createTables() 
    {
        try {
            
            ExampleTable::getInstance()->create();





        } catch (Throwable $e)
        {
            Logger::error($e->getMessage());
            throw $e;
        }
    }

    public static function dropTables() 
    {
        try {
            ExampleTable::getInstance()->drop();








        } catch (Throwable $e)
        {
            Logger::error($e->getMessage());
            throw $e;
        }
    }
}