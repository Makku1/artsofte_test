<?php

namespace App\Layer\Persistence\Repository;

use App\Layer\Domain\Entity\Car;
use App\Layer\Domain\CarInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CarRepository extends ServiceEntityRepository implements CarInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function getAll(): array
    {
        return parent::findAll();
    }

    public function getById(int $id): ?Car
    {
        return parent::find($id);
    }
}