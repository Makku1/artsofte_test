<?php

namespace App\Layer\UseCase\Car;

use App\Layer\Domain\CarInterface;
use App\Layer\Domain\Entity\Car\Car;

class ListCarsUseCase
{
    private CarInterface $carInterface;

    public function __construct(CarInterface $carInterface)
    {
        $this->carInterface = $carInterface;
    }

    /**
     * @return Car[]
     */
    public function getAll(): array
    {
        return $this->carInterface->getAll();
    }

    public function getById(int $id): ?Car
    {
        return $this->carInterface->getById($id);
    }
}