<?php

declare(strict_types=1);

namespace App\Tests\TestHelpers;

use JsonException;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

final class JsonResponseHelper
{
    /**
     * @return array<mixed>
     *
     * @throws JsonException
     */
    public static function decodeJsonResponse(KernelBrowser $client): array
    {
        $responseContent = $client->getResponse()->getContent();

        Assert::assertIsString($responseContent);

        $responseData = json_decode(
            $responseContent,
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        Assert::assertIsArray($responseData);

        return $responseData;
    }
}