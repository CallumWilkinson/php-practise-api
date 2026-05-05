<?php

declare(strict_types = 1);

namespace App\Application\ProcurementRequest;

use App\Entity\ProcurementRequest;

final class ListProcurementRequestsService
{
    public function __construct(
        private ProcurementRequestRepositoryInterface $procurementRequestRepository
    ) {
    }

    /**
     * @return ProcurementRequest[]
     */
    public function list(): array
    {
        return $this->procurementRequestRepository->findAll();
    }
}