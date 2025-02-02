<?php

namespace App\Layer\Presentation\Controller\Car;

use App\Layer\UseCase\Car\ListCarsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CarController extends AbstractController
{
    private ListCarsUseCase $listCarsUseCase;
    private SerializerInterface $serializer;

    public function __construct(
        ListCarsUseCase $listCarsUseCase,
        SerializerInterface $serializer,
    ) {
        $this->listCarsUseCase   = $listCarsUseCase;
        $this->serializer = $serializer;
    }

    #[Route('/api/v1/cars', name: 'api_list_cars', methods: ['GET'])]
    public function listAll(): JsonResponse
    {
        $cars = $this->listCarsUseCase->getAll();

        return new JsonResponse(
            $this->serializer->serialize($cars, 'json', ['groups' => 'car:read']),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/api/v1/cars/{id}', name: 'api_list_car_by_id', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function listById(int $id): JsonResponse
    {
        $car = $this->listCarsUseCase->getById($id);

        if (!$car) {
            return new JsonResponse(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            $this->serializer->serialize($car, 'json', ['groups' => 'car:read']),
            Response::HTTP_OK,
            [],
            true
        );
    }
}