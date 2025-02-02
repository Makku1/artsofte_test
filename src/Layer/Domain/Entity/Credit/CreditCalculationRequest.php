<?php

namespace App\Layer\Domain\Entity\Credit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

class CreditCalculationRequest
{
    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request:read'])]
    private int $carId;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request:read'])]
    private int $initialPayment;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request:read'])]
    private int $loanTerm;

    public function __construct(
        int $carId,
        int $initialPayment,
        int $loanTerm
    ) {
        $this->carId = $carId;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
    }

    public function getCarId(): int
    {
        return $this->carId;
    }

    public function getInitialPayment(): int
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

}