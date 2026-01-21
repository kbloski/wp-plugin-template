<?php 

namespace PluginTemplate\Inc\Infrastructure\Repositories;

use PluginTemplate\Inc\Core\Abstracts\AbstractSingleton;
use PluginTemplate\Inc\Core\Logger\Logger;
use PluginTemplate\Inc\Domain\Entities\ExampleEntity;
use Throwable;

class ExampleRepository extends AbstractSingleton
{
    public function getById( int $id) : ?ExampleEntity
    {
        try {

        } catch (Throwable $e)
        {
            Logger::error($e->getMessage());
            throw $e;
        }
    }
}