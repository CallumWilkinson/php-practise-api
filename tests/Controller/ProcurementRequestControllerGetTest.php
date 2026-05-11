<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Tests\TestHelpers\JsonResponseHelper;

final class ProcurementRequestControllerGetTest extends WebTestCase{


    /**
     * @throws JsonException
     */
    public function testGetRequestsReturnsJsonList(): void
    {
        $client = self::createClient();

        $client->request('GET', '/requests');

        self::assertResponseIsSuccessful();

        $responseData = JsonResponseHelper::decodeJsonResponse($client);
    }

    

}