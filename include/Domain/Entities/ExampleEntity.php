<?php

namespace PluginTemplate\Inc\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;

// Tablename is getting from .../Infrastructure/Doctrine/TableNameSubscriber

#[ORM\Entity]
class ExampleEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public ?int $id = null;

    #[ORM\Column(type: 'integer')]
    public int $counter = 0;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $updated_at;

    public function __construct(int $counter = 0)
    {
        $this->counter = $counter;
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }
}
