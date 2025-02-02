<?php

namespace App\Layer\Domain;

use App\Layer\Domain\Entity\Credit\CreditProgram;
use App\Layer\Domain\Entity\Credit\CreditCalculationRequest;
use App\Layer\Domain\Entity\Credit\CreditRequestData;
interface CreditInterface
{
    public function calculateCredit(CreditCalculationRequest $creditRequest): CreditProgram;
    public function saveCreditRequest(CreditRequestData $creditRequestData): bool;
}