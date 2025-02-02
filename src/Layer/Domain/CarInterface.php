<?php

namespace App\Layer\Domain;

use App\Layer\Domain\Entity\Car\Car;

interface CarInterface
{
    public function getAll(): array;
    public function getById(int $id): ?Car;
}