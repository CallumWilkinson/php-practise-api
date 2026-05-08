<?php

declare(strict_types=1);


namespace App\Application\ProcurementRequest\Exception;

use RuntimeException;

final class ProcurementRequestCannotBeSubmittedException extends RuntimeException
{
    public static function becauseStatusIsNotDraft(string $currentStatus): self{
        return new self(sprintf(
            'Only draft procurement requests can be submitted. Current status is %s.',
            $currentStatus
        ));
    }
}