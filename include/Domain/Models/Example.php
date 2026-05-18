<?php

namespace PluginTemplate\Inc\Domain\Models;

use DateTimeImmutable;

class Example
{
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function __construct(
        public ?int $id,
        public int $userId,
        public string $message,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
    )
    {
        $now = new DateTimeImmutable();
        $this->createdAt = !empty($createdAt) ? $createdAt : $now;
        $this->updatedAt = !empty($updatedAt) ? $updatedAt : $now;
    }
}