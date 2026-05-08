<?php

declare(strict_types=1);

namespace App\Tests\TestHelpers;

use App\Entity\ProcurementRequest;
use DateTimeImmutable;

final class ProcurementRequestBuilder
{
    public static function createDraft(): ProcurementRequest
    {
        return self::createWithStatus('draft');
    }

    public static function createSubmitted(): ProcurementRequest
    {
        return self::createWithStatus('submitted');
    }

    private static function createWithStatus(string $status): ProcurementRequest
    {
        $procurementRequest = new ProcurementRequest();

        $procurementRequest->setTitle('Laptop approval');
        $procurementRequest->setDescription('Need a laptop for a new starter.');
        $procurementRequest->setStatus($status);
        $procurementRequest->setCreatedAt(
            new DateTimeImmutable('2026-05-05T09:30:00+00:00')
        );

        return $procurementRequest;
    }
}
