<?php 

namespace PluginTemplate\Inc\Domain\Abstracts;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Domain\Interfaces\TableInterface;

abstract class AbstractTable extends AbstractSingleton implements TableInterface
{
    protected string $tableName;

    /**
     * Chroniony konstruktor — uniemożliwia tworzenie instancji z zewnątrz
     */
    protected function __construct()
    {
    }

    abstract public function create(): void;
    abstract public function drop(): void;
}
