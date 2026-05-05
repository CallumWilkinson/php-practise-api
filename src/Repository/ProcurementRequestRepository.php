<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Application\ProcurementRequest\ProcurementRequestRepositoryInterface;
use App\Entity\ProcurementRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProcurementRequest>
 */
final class ProcurementRequestRepository extends ServiceEntityRepository implements ProcurementRequestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcurementRequest::class);
    }

    public function save(ProcurementRequest $procurementRequest): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($procurementRequest);
        $entityManager->flush();
    }
}