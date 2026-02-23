<?php

namespace PluginTemplate\Inc\Domain\Models;

class Example
{
    public ?int $id = null;

    public int $counter = 0;
    public \DateTime $created_at;
    public \DateTime $updated_at;

    public function __construct(
        int $counter = 0
    )
    {
        $this->counter = $counter;
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    /**
     * @param [key => value][]
     */
    public static function fromArray(array $data): self
    {
        $example = new self((int) ($data['counter'] ?? 0));

        $example->id = isset($data['id']) ? (int) $data['id'] : null;
        $example->created_at = isset($data['created_at'])
            ? new \DateTime($data['created_at'])
            : new \DateTime();
        $example->updated_at = isset($data['updated_at'])
            ? new \DateTime($data['updated_at'])
            : new \DateTime();

        return $example;
    }
}
