<?php

declare(strict_types=1);

namespace App\Tests\TestHelpers;

use App\Application\ProcurementRequest\ProcurementRequestRepositoryInterface;
use App\Entity\ProcurementRequest;

final class FakeProcurementRequestRepository implements ProcurementRequestRepositoryInterface
{
    public int $saveCallCount = 0;

    public ?ProcurementRequest $savedProcurementRequest = null;

    public ?int $lastRequestedId = null;

    /**
     * @var array<int, ProcurementRequest>
     */
    private array $requestsById = [];

    public function save(ProcurementRequest $procurementRequest): void
    {
        $this->saveCallCount++;

        $this->savedProcurementRequest = $procurementRequest;
    }

    public function findById(int $id): ?ProcurementRequest
    {
        $this->lastRequestedId = $id;

        if (!array_key_exists($id, $this->requestsById)) {
            return null;
        }

        return $this->requestsById[$id];
    }

    /**
     * @return ProcurementRequest[]
     */
    public function findAll(): array
    {
        return array_values($this->requestsById);
    }

    public function addExistingRequest(int $id, ProcurementRequest $procurementRequest): void
    {
        $this->requestsById[$id] = $procurementRequest;
    }
}
