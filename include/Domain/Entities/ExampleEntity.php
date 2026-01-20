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
    public ?int $id = null;

    #[ORM\Column(type: 'integer')]
    public int $counter = 0;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $created_at;

    #[ORM\Column(type: 'datetime')]
    public \DateTime $updated_at;

    // Konstruktor
    public function __construct(int $counter = 0)
    {
        $this->counter = $counter;
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }
}
