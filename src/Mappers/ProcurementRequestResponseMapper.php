<?php

declare(strict_types = 1);

namespace App\Response;

use App\Entity\ProcurementRequest;

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
        return [
            'id' => $procurementRequest->getId(),
            'title' => $procurementRequest->getTitle(),
            'description' => $procurementRequest->getDescription(),
            'status' => $procurementRequest->getStatus(),
            'createdAt' => $procurementRequest->getCreatedAt()->format('c'),
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