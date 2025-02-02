<?php

namespace App\Layer\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Model
{
    #[ORM\Column(type: 'integer')]
    #[Groups(['car:read', 'brand:read'])]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['car:read', 'model:read'])]
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}