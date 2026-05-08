<?php

declare(strict_types=1);


namespace App\Application\ProcurementRequest\Exception;

use RuntimeException;

final class ProcurementRequestNotFoundException extends RuntimeException
{
    public static function forId(int $id): self{
        return new self(sprintf('Procurement request with id %d was not found.', $id));
    }
}