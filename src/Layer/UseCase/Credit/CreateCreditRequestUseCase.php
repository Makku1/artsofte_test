<?php

namespace App\Layer\UseCase\Credit;

use App\Layer\Domain\CreditInterface;
use App\Layer\Domain\Entity\Credit\CreditRequestData;

class CreateCreditRequestUseCase
{
    private CreditInterface $creditInterface;

    public function __construct(CreditInterface $creditInterface)
    {
        $this->creditInterface = $creditInterface;
    }

    public function create(int $carId, int $programId, int $initialPayment, int $loanTerm): bool
    {
        $creditRequest = new CreditRequestData($carId, $programId, $initialPayment, $loanTerm);
        $this->creditInterface->saveCreditRequest($creditRequest);
        return true;
    }
}