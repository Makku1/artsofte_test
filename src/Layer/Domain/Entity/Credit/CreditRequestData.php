<?php

namespace App\Layer\Domain\Entity\Credit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

class CreditRequestData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request_data:read'])]
    private int $carId;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request_data:read'])]
    private int $programId;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request_data:read'])]
    private int $initialPayment;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_request_data:read'])]
    private int $loanTerm;

    public function __construct(
        int $carId,
        int $programId,
        int $initialPayment,
        int $loanTerm
    ) {
        $this->carId = $carId;
        $this->programId = $programId;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarId(): int
    {
        return $this->carId;
    }

    public function getProgramId(): int
    {
        return $this->programId;
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