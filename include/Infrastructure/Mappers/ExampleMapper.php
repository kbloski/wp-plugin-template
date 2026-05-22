<?php 

namespace PluginTemplate\Inc\Infrastructure\Mappers;

use DateTimeImmutable;
use PluginTemplate\Inc\Domain\Models\Example;

class ExampleMapper
{
    public function mapFromDb( array $row) : Example
    {
        return new Example(
            id: $row['id'],
            userId: $row['user_id'],
            message: $row['message'],
            createdAt: new DateTimeImmutable($row['createdAt']),
            updatedAt: new DateTimeImmutable($row['updatedAt'])
        );
    }
}