<?php

declare(strict_types=1);

namespace App\Tests\Application\ProcurementRequest;

use App\Application\ProcurementRequest\CreateProcurementRequestService;
use App\Tests\TestHelpers\FakeProcurementRequestRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class CreateProcurementRequestServiceTest extends TestCase
{
    public function testCreateBuildsARequestObjectAndSavesIt(): void
    {
        //arrange
        $repository = new FakeProcurementRequestRepository();
        $service = new CreateProcurementRequestService($repository);

        //act
        $procurementRequest = $service->create(
            'Laptop approval',
            'Need a laptop for a new starter.'
        );

        //assert
        self::assertSame('Laptop approval', $procurementRequest->getTitle());
        self::assertSame('Need a laptop for a new starter.', $procurementRequest->getDescription());
        self::assertSame('draft', $procurementRequest->getStatus());
        self::assertInstanceOf(DateTimeImmutable::class, $procurementRequest->getCreatedAt());

        self::assertSame(1, $repository->saveCallCount);
        self::assertSame($procurementRequest, $repository->savedProcurementRequest);
    }
}

