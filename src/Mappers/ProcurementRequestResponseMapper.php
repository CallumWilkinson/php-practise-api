<?php

declare(strict_types = 1);

namespace App\Mappers;

use App\Entity\ProcurementRequest;
use LogicException;

final class ProcurementRequestResponseMapper
{
    /**
     * @return array{
     *     id: int|null,
     *     title: string|null,
     *     description: string|null,
     *     status: string|null,
     *     createdAt: string
     * }
     */
    public function map(ProcurementRequest $procurementRequest): array
    {
        $createdAt = $procurementRequest->getCreatedAt();

        if ($createdAt === null) {
            throw new LogicException('Cannot map a procurement request without a created at timestamp.');
        }

        return [
            'id' => $procurementRequest->getId(),
            'title' => $procurementRequest->getTitle(),
            'description' => $procurementRequest->getDescription(),
            'status' => $procurementRequest->getStatus(),
            'createdAt' => $createdAt->format('c'),
        ];
    }

    /**
     * @param ProcurementRequest[] $procurementRequests
     *
     * @return array<int, array{
     *     id: int|null,
     *     title: string|null,
     *     description: string|null,
     *     status: string|null,
     *     createdAt: string
     * }>
     */
    public function mapMany(array $procurementRequests): array
    {
        $responseData = [];

        foreach ($procurementRequests as $procurementRequest) {
            $responseData[] = $this->map($procurementRequest);
        }

        return $responseData;
    }
}
