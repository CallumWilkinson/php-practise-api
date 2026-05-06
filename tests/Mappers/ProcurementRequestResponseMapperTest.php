<?php

declare(strict_types=1);

namespace App\Tests\Mappers;

use App\Entity\ProcurementRequest;
use App\Mappers\ProcurementRequestResponseMapper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class ProcurementRequestResponseMapperTest extends TestCase
{
    public function testMapReturnsApiResponseShape(): void
    {
        $createdAt = new DateTimeImmutable('2026-05-05T09:30:00+00:00');

        $procurementRequest = new ProcurementRequest();
        $procurementRequest->setTitle('Laptop approval');
        $procurementRequest->setDescription('Need a laptop for a new starter.');
        $procurementRequest->setStatus('draft');
        $procurementRequest->setCreatedAt($createdAt);

        $mapper = new ProcurementRequestResponseMapper();

        $responseData = $mapper->map($procurementRequest);

        self::assertArrayHasKey('id', $responseData);
        self::assertSame('Laptop approval', $responseData['title']);
        self::assertSame('Need a laptop for a new starter.', $responseData['description']);
        self::assertSame('draft', $responseData['status']);
        self::assertSame('2026-05-05T09:30:00+00:00', $responseData['createdAt']);
    }
}