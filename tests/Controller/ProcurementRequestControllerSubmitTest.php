<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\ProcurementRequest;
use App\Tests\TestHelpers\JsonResponseHelper;
use Symfony\Component\HttpFoundation\Response;


final class ProcurementRequestControllerSubmitTest extends ControllerTestCase
{
    public function testSubmitDraftProcurementRequestsReturnsUpdatedRequest() : void
    {
        //arrange
        $procurementRequest = $this->saveProcurementRequest();
        self::assertSame('draft', $procurementRequest->getStatus());
        $id = $procurementRequest->getId();
        
        //act
        $this->client->request('POST', sprintf('/requests/%d/submit', $id));
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        $responseData = JsonResponseHelper::decodeJsonResponse($this->client);

        //assert
        self::assertSame($id, $responseData['id']);
        self::assertSame('Laptop approval', $responseData['title']);
        self::assertSame('Need a laptop for a new starter.', $responseData['description']);
        self::assertSame('submitted', $responseData['status']);

        $this->entityManager->clear();

        $savedRequest = $this->entityManager->getRepository(ProcurementRequest::class)->find($id);

        self::assertInstanceOf(ProcurementRequest::class, $savedRequest);
        self::assertSame('submitted', $savedRequest->getStatus());
    }
}