<?php

declare(strict_types = 1);

namespace App\Application\ProcurementRequest;

use App\Entity\ProcurementRequest;

interface ProcurementRequestRepositoryInterface
{
    public function save(ProcurementRequest $procurementRequest): void;
    
    /**
     * @return ProcurementRequest[]
     */
    public function findAll(): array;
}