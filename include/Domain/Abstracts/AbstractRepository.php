<?php

namespace PluginTemplate\Inc\Domain\Abstracts;

use LogicException;
use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Domain\Interfaces\RepositoryInterface;
use PluginTemplate\Inc\Domain\Interfaces\TableInterface;

abstract class AbstractRepository extends AbstractSingleton implements RepositoryInterface
{
    protected string $tableName;

    /**
     * Chroniony konstruktor — uniemożliwia tworzenie instancji z zewnątrz
     */
    protected function __construct()
    {
    }

    public function upsertMany(array $items) 
    {
        throw new LogicException("Meethod not implemented");
    }

    public function getAll(array $props) : array
    {
        throw new LogicException("Meethod not implemented");
    }
}
