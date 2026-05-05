<?php

declare(strict_types = 1);

namespace App\Application\ProcurementRequest;

use App\Entity\ProcurementRequest;
use DateTimeImmutable;

final class CreateProcurementRequestService
{
    public function __construct(
        private ProcurementRequestRepositoryInterface $procurementRequestRepository
    ) {
    }

    public function create(string $title, string $description): ProcurementRequest
    {
        $procurementRequest = new ProcurementRequest();
        $procurementRequest->setTitle($title);
        $procurementRequest->setDescription($description);
        $procurementRequest->setStatus('draft');
        $procurementRequest->setCreatedAt(new DateTimeImmutable());

        $this->procurementRequestRepository->save($procurementRequest);

        return $procurementRequest;
    }
}