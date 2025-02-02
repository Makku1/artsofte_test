<?php

namespace App\Layer\Domain\Entity\Credit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

class CreditProgram
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'float')]
    #[Groups(['credit_calculation:read'])]
    private float $interestRate;

    #[ORM\Column(type: 'int')]
    #[Groups(['credit_calculation:read'])]
    private int $monthlyPayment;

    private string $title;

    public function __construct(
        int $id,
        float $interestRate,
        int $monthlyPayment,
        string $title
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->interestRate = $interestRate;
        $this->monthlyPayment = $monthlyPayment;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getMonthlyPayment(): int
    {
        return $this->monthlyPayment;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}