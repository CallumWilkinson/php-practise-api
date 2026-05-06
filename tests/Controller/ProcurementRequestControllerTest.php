<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ProcurementRequestControllerTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function testPostRequestsCreatesDraftProcurementRequest(): void
    {
        //arrange
        $client = self::createClient();

        $payload = [
            'title' => 'Laptop approval',
            'description' => 'Need a laptop for a new starter.',
        ];

        //act
        $client->request(
            'POST',
            '/requests',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload, JSON_THROW_ON_ERROR)
        );

        //assert
        self::assertResponseStatusCodeSame(201);

        $responseData = self::decodeJsonResponse($client);

        self::assertSame('Laptop approval', $responseData['title']);
        self::assertSame('Need a laptop for a new starter.', $responseData['description']);
        self::assertSame('draft', $responseData['status']);
        self::assertArrayHasKey('id', $responseData);
        self::assertArrayHasKey('createdAt', $responseData);
    }

    /**
     * @throws JsonException
     */
    public function testPostRequestsReturnsBadRequestWhenTitleIsMissing(): void
    {
        $client = self::createClient();

        $payload = [
            'description' => 'Need a laptop for a new starter.',
        ];

        $client->request(
            'POST',
            '/requests',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(400);

        $responseData = self::decodeJsonResponse($client);

        self::assertArrayHasKey('error', $responseData);
    }

    /**
     * @throws JsonException
     */
    public function testPostRequestsReturnsBadRequestWhenDescriptionIsMissing(): void
    {
        $client = self::createClient();

        $payload = [
            'title' => 'Laptop approval',
        ];

        $client->request(
            'POST',
            '/requests',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(400);

        $responseData = self::decodeJsonResponse($client);

        self::assertArrayHasKey('error', $responseData);
    }

    /**
     * @throws JsonException
     */
    public function testGetRequestsReturnsJsonList(): void
    {
        $client = self::createClient();

        $client->request('GET', '/requests');

        self::assertResponseIsSuccessful();

        $responseData = self::decodeJsonResponse($client);
    }

    /**
     * @throws JsonException
     */
    public function testPostRequestsReturnsBadRequestWhenTitleIsNotAString(): void
    {
        $client = self::createClient();

        $payload = [
            'title' => 123,
            'description' => 'Need a laptop for a new starter.',
        ];

        $client->request(
            'POST',
            '/requests',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($payload, JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(400);

        $responseData = self::decodeJsonResponse($client);

        self::assertArrayHasKey('error', $responseData);
    }

    /**
     * @return array<mixed>
     *
     * @throws JsonException
     */
    private static function decodeJsonResponse(KernelBrowser $client): array
    {
        $responseContent = $client->getResponse()->getContent();

        self::assertIsString($responseContent);

        $responseData = json_decode(
            $responseContent,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        self::assertIsArray($responseData);

        return $responseData;
    }
}
