<?php

namespace App\Layer\UseCase\Credit;

use App\Layer\Domain\CreditInterface;
use App\Layer\Domain\Entity\Credit\CreditProgram;
use App\Layer\Domain\Entity\Credit\CreditCalculationRequest;

class CalculateCreditUseCase
{
    private CreditInterface $creditInterface;

    public function __construct(CreditInterface $creditInterface)
    {
        $this->creditInterface = $creditInterface;
    }

    public function calculate(int $carId, int $initialPayment, int $loanTerm): CreditProgram
    {
        $creditRequest = new CreditCalculationRequest($carId, $initialPayment, $loanTerm);
        return $this->creditInterface->calculateCredit($creditRequest);
    }
}