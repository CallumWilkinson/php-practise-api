<?php

declare(strict_types = 1);

namespace App\Application\ProcurementRequest;

use App\Entity\ProcurementRequest;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class CreateProcurementRequestService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function create(string $title, string $description): ProcurementRequest
    {
        $procurementRequest = new ProcurementRequest();
        $procurementRequest->setTitle($title);
        $procurementRequest->setDescription($description);
        $procurementRequest->setStatus('draft');
        $procurementRequest->setCreatedAt(new DateTimeImmutable());

        $this->entityManager->persist($procurementRequest);
        $this->entityManager->flush();

        return $procurementRequest;
    }
}