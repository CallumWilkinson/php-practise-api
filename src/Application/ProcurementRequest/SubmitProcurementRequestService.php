<?php

declare(strict_types=1);

namespace App\Application\ProcurementRequest;

use App\Application\ProcurementRequest\Exception\ProcurementRequestCannotBeSubmittedException;
use App\Application\ProcurementRequest\Exception\ProcurementRequestNotFoundException;
use App\Entity\ProcurementRequest;

final class SubmitProcurementRequestService
{
    private const STATUS_DRAFT = 'draft';
    private const STATUS_SUBMITTED = 'submitted';

    public function __construct(
        private ProcurementRequestRepositoryInterface $repository
    )
    {
      
    }

    public function submit(int $id): ProcurementRequest
    {
        $procurementRequest = $this->repository->findById($id);

        if($procurementRequest === null)
        {
            throw ProcurementRequestNotFoundException::forId($id);
        }

        $currentStatus = $procurementRequest->getStatus();

        if($currentStatus !== self::STATUS_DRAFT)
        {
            throw ProcurementRequestCannotBeSubmittedException::becauseStatusIsNotDraft(
                $currentStatus ?? 'unset'
            );
        }

        $procurementRequest->setStatus(self::STATUS_SUBMITTED);

        $this->repository->save($procurementRequest);

        return $procurementRequest;
    }

}
