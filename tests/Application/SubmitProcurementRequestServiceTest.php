<?php

declare(strict_types=1);

namespace App\Tests\Application\ProcurementRequest;

use App\Application\ProcurementRequest\SubmitProcurementRequestService;
use App\Tests\TestHelpers\FakeProcurementRequestRepository;
use App\Tests\TestHelpers\ProcurementRequestBuilder;
use PHPUnit\Framework\TestCase;

final class SubmitProcurementRequestServiceTest extends TestCase
{
    public function testSubmitChangesDraftRequestToSubmittedAndSavesIt(): void
    {
        //arrange
        $procurementRequest = ProcurementRequestBuilder::createDraft();
        $repository = new FakeProcurementRequestRepository();
        $repository->addExistingRequest(123, $procurementRequest);
        $service = new SubmitProcurementRequestService($repository);

        //act
        $result = $service->submit(123);

        //assert
        self::assertSame($procurementRequest, $result);
        self::assertSame('submitted', $result->getStatus());
        self::assertSame($procurementRequest, $repository->savedProcurementRequest);
        self::assertSame(123, $repository->lastRequestedId);
    }
}
