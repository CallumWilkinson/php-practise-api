<?php

declare(strict_types=1);

namespace App\Tests\Application\ProcurementRequest;

use App\Application\ProcurementRequest\CreateProcurementRequestService;
use App\Tests\TestHelpers\FakeProcurementRequestRepository;
use DateTimeImmutable;
use InvalidArgumentException;
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

    public function testCreateThrowsWhenTitleIsBlank(): void
    {
        $repository = new FakeProcurementRequestRepository();
        $service = new CreateProcurementRequestService($repository);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Title cannot be blank.');

        try {
            $service->create('   ', 'Need a laptop for a new starter.');
        } finally {
            self::assertSame(0, $repository->saveCallCount);
            self::assertNull($repository->savedProcurementRequest);
        }
    }

    public function testCreateThrowsWhenDescriptionIsBlank(): void
    {
        $repository = new FakeProcurementRequestRepository();
        $service = new CreateProcurementRequestService($repository);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Description cannot be blank.');

        try {
            $service->create('Laptop approval', '   ');
        } finally {
            self::assertSame(0, $repository->saveCallCount);
            self::assertNull($repository->savedProcurementRequest);
        }
    }
}

