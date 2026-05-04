<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\ProcurementRequest;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProcurementRequestController extends AbstractController
{
    #[Route('/requests', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $requests = $entityManager
            ->getRepository(ProcurementRequest::class)
            ->findAll();

        $responseData = [];

        foreach ($requests as $procurementRequest) {
            $responseData[] = [
                'id' => $procurementRequest->getId(),
                'title' => $procurementRequest->getTitle(),
                'description' => $procurementRequest->getDescription(),
                'status' => $procurementRequest->getStatus(),
                'createdAt' => $procurementRequest->getCreatedAt()->format('c'),
            ];
        }

        return $this->json($responseData);
    }

    #[Route('/requests', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!is_array($requestData)) {
            return $this->json(['error' => 'Invalid JSON body.'], 400);
        }

        if (empty($requestData['title'])) {
            return $this->json(['error' => 'Title is required.'], 400);
        }

        if (empty($requestData['description'])) {
            return $this->json(['error' => 'Description is required.'], 400);
        }

        $procurementRequest = new ProcurementRequest();
        $procurementRequest->setTitle($requestData['title']);
        $procurementRequest->setDescription($requestData['description']);
        $procurementRequest->setStatus('draft');
        $procurementRequest->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($procurementRequest);
        $entityManager->flush();

        return $this->json([
            'id' => $procurementRequest->getId(),
            'title' => $procurementRequest->getTitle(),
            'description' => $procurementRequest->getDescription(),
            'status' => $procurementRequest->getStatus(),
            'createdAt' => $procurementRequest->getCreatedAt()->format('c'),
        ], 201);
    }
}