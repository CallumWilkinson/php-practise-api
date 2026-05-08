<?php

declare(strict_types = 1);

namespace App\Application\ProcurementRequest;

use App\Entity\ProcurementRequest;
use DateTimeImmutable;
use InvalidArgumentException;

final class CreateProcurementRequestService
{
    public function __construct(
        private ProcurementRequestRepositoryInterface $procurementRequestRepository
    ) {
    }

    public function create(string $title, string $description): ProcurementRequest
    {
        if (trim($title) === '') {
            throw new InvalidArgumentException('Title cannot be blank.');
        }

        if (trim($description) === '') {
            throw new InvalidArgumentException('Description cannot be blank.');
        }

        $procurementRequest = new ProcurementRequest();
        $procurementRequest->setTitle($title);
        $procurementRequest->setDescription($description);
        $procurementRequest->setStatus('draft');
        $procurementRequest->setCreatedAt(new DateTimeImmutable());

        $this->procurementRequestRepository->save($procurementRequest);

        return $procurementRequest;
    }
}
