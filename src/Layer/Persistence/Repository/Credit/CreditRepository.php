<?php

namespace App\Layer\Persistence\Repository\Credit;

use App\Layer\Domain\CreditInterface;
use App\Layer\Domain\Entity\Credit\CreditProgram;
use App\Layer\Domain\Entity\Credit\CreditCalculationRequest;
use App\Layer\Domain\Entity\Credit\CreditRequestData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class CreditRepository extends ServiceEntityRepository implements CreditInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct($registry, CreditCalculationRequest::class);
        $this->entityManager = $entityManager;
    }

    public function calculateCredit(CreditCalculationRequest $creditRequest): CreditProgram
    {
        if (
            $creditRequest->getInitialPayment() > 200000 &&
            $creditRequest->getLoanTerm() < 5
        ) {
            return $this->getSpecialCreditProgram();
        }

        return $this->getAnyCreditProgram();
    }

    public function saveCreditRequest(CreditRequestData $creditRequestData): bool
    {
        $this->entityManager->persist($creditRequestData);
        $this->entityManager->flush();

        return true;
    }

    private function getSpecialCreditProgram(): CreditProgram
    {
        $interestRate = 12.3;
        $monthlyPayment = 9800;

        return $this->entityManager->getRepository(CreditProgram::class)
            ->createQueryBuilder('c')
            ->where('c.interestRate = :interestRate')
            ->where('c.monthlyPayment = :monthlyPayment')
            ->setParameter('interestRate', $interestRate)
            ->setParameter('monthlyPayment', $monthlyPayment)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function getAnyCreditProgram(): CreditProgram
    {
        $programId = rand(1, 10);

        return $this->entityManager->getRepository(CreditProgram::class)
            ->createQueryBuilder('c')
            ->where('c.id = :programId')
            ->setParameter('programId', $programId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}