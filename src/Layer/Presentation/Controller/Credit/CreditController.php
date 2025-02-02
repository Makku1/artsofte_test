<?php

namespace App\Layer\Presentation\Controller\Credit;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Layer\UseCase\Credit\CalculateCreditUseCase;
use App\Layer\UseCase\Credit\CreateCreditRequestUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreditController extends AbstractController
{
    private SerializerInterface $serializer;

    private CalculateCreditUseCase $calculateCreditRequestUseCase;
    private CreateCreditRequestUseCase $createCreditRequestUseCase;

    public function __construct(
        SerializerInterface $serializer,
        CalculateCreditUseCase $calculateCreditRequestUseCase,
        CreateCreditRequestUseCase $createCreditRequestUseCase,
    ) {
        $this->serializer = $serializer;
        $this->calculateCreditRequestUseCase = $calculateCreditRequestUseCase;
        $this->createCreditRequestUseCase = $createCreditRequestUseCase;
    }

    #[Route(
        '/api/v1/credit/calculate?carId={carId}&initialPayment={initialPayment}&loanTerm={loanTerm}',
        name: 'api_calculate_credit',
        requirements: ['carId' => '\d+', 'initialPayment' => '\d+', 'loanTerm' => '\d+'],
        methods: ['GET']
    )]
    public function calculate(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['carId'], $data['initialPayment'], $data['loanTerm'])) {
            return $this->json(['error' => 'Missing required parameters'], 400);
        }

        $carId = $data['carId'];
        $initialPayment = $data['initialPayment'];
        $loanTerm = $data['loanTerm'];

        $calculatedProgram = $this->calculateCreditRequestUseCase->calculate(
            $carId,
            $initialPayment,
            $loanTerm
        );

        return new JsonResponse(
            $this->serializer->serialize($calculatedProgram, 'json', ['groups' => 'CreditProgram:read']),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route(
        '/api/v1/request',
        name: 'api_save_credit_request',
        requirements: ['carId' => '\d+', 'programId' => '\d+', 'initialPayment' => '\d+', 'loanTerm' => '\d+'],
        methods: ['POST']
    )]
    public function save(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['carId'], $data['programId'], $data['initialPayment'], $data['loanTerm'])) {
            return $this->json(['error' => 'Missing required parameters'], 400);
        }

        $carId = $data['carId'];
        $programId = $data['programId'];
        $initialPayment = $data['initialPayment'];
        $loanTerm = $data['loanTerm'];

        $credit = $this->createCreditRequestUseCase->create($carId, $programId, $initialPayment, $loanTerm);

        if (!$credit) {
            return new JsonResponse(['error' => 'An error has happened'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['success' => true], Response::HTTP_OK);
    }
}