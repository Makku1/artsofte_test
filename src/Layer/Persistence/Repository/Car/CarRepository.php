<?php

namespace App\Layer\Persistence\Repository\Car;

use App\Layer\Domain\CarInterface;
use App\Layer\Domain\Entity\Car\Car;
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
        return $this->createQueryBuilder('c')
            ->leftJoin('c.brand', 'b')
            ->addSelect('b')
            ->getQuery()
            ->getResult();
    }

    public function getById(int $id): ?Car
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.brand', 'b')
            ->addSelect('b')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}