<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Application\ProcurementRequest\CreateProcurementRequestService;
use App\Application\ProcurementRequest\Exception\ProcurementRequestCannotBeSubmittedException;
use App\Application\ProcurementRequest\Exception\ProcurementRequestNotFoundException;
use App\Application\ProcurementRequest\ListProcurementRequestsService;
use App\Application\ProcurementRequest\SubmitProcurementRequestService;
use App\Mappers\ProcurementRequestResponseMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProcurementRequestController extends AbstractController
{
    public function __construct(
        private ProcurementRequestResponseMapper $responseMapper
    ) {
    }

    #[Route('/requests', methods: ['GET'])]
    public function index(ListProcurementRequestsService $listProcurementRequestsService): JsonResponse
    {
        $requests = $listProcurementRequestsService->list();

        return $this->json($this->responseMapper->mapMany($requests));
    }

    #[Route('/requests', methods: ['POST'])]
    public function create(Request $request, CreateProcurementRequestService $createProcurementRequestService): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!is_array($requestData)) {
            return $this->json(['error' => 'Invalid JSON body.'], 400);
        }

        if (
            !array_key_exists('title', $requestData)
            || !is_string($requestData['title'])
            || trim($requestData['title']) === ''
        ) {
            return $this->json(['error' => 'Title is required.'], 400);
        }

        if (
            !array_key_exists('description', $requestData)
            || !is_string($requestData['description'])
            || trim($requestData['description']) === ''
        ) {
            return $this->json(['error' => 'Description is required.'], 400);
        }

        $procurementRequest = $createProcurementRequestService->create(
            $requestData['title'],
            $requestData['description']
        );

        return $this->json(
            $this->responseMapper->map($procurementRequest),
            201
        );
    }

    #[Route('/requests/{id<\d+>}/submit', methods: ['POST'])]
    public function submit(
        int $id,
        SubmitProcurementRequestService $submitProcurementRequestService
    ) : JsonResponse {
        try {
            $procurementRequest = $submitProcurementRequestService->submit($id);
        } catch (ProcurementRequestNotFoundException) {
         return $this->json(
            ['error' => 'Procurement request not found.'],
            Response::HTTP_NOT_FOUND
         );
        } catch (ProcurementRequestCannotBeSubmittedException $exception) {
            return $this->json(
                ['error' => $exception->getMessage()],
                Response::HTTP_CONFLICT
            );
         }

         return $this->json($this->responseMapper->map($procurementRequest));
        }
    
}
