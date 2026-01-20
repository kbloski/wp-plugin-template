<?php

namespace PluginTemplate\Inc\Domain\Entities;

use Doctrine\ORM\Mapping as ORM;
use PluginTemplate\Inc\Domain\Enums\TableNamesEnum;

#[ORM\Entity]
#[ORM\Table(name: 'wp_plugintemplate_example' /* TableNamesEnum::EXAMPLE() */)]
class ExampleEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $counter = 0;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updated_at;

    // Konstruktor
    public function __construct(int $counter = 0)
    {
        $this->counter = $counter;
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }


    // GETTERY
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    // SETTERY
    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }
}
