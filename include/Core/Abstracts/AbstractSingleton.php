<?php

namespace AstraToolbox\Inc\Core\Abstracts;

abstract class AbstractSingleton
{
    /**
     * Pojedyncza instancja
     * 
     * @var static[]
     */
    private static array $instances = [];

    /**
     * Zwraca instancję singletona
     *
     * @return static
     */
    public static function getInstance()
    {   
        $class = static::class; // nazwa klasy wywołującej

        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static();
        }

        return self::$instances[$class];
    }

    /**
     * Chroniony konstruktor — uniemożliwia tworzenie instancji z zewnątrz
     */
    protected function __construct()
    {
    }

    /**
     * Zapobiega klonowaniu
     */
    final protected function __clone()
    {
    }

    /**
     * Zapobiega unserializacji
     */
    final public function __wakeup()
    {
    }
}
