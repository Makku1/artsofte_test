<?php

namespace App\Layer\Domain\Entity\Car;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Brand::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['car:read'])]
    private Brand $brand;

    #[ORM\ManyToOne(targetEntity: Model::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['car:read'])]
    private Model $model;

    #[ORM\Column(type: 'string')]
    #[Groups(['car:read'])]
    private string $photo;

    #[ORM\Column(type: 'int')]
    #[Groups(['car:read'])]
    private int $price;

    public function __construct(
        int $id,
        Brand $brand,
        Model $model,
        string $photo,
        int $price
    ) {
        $this->id = $id;
        $this->brand  = $brand;
        $this->model = $model;
        $this->photo  = $photo;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getPhoto(): int
    {
        return $this->photo;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}