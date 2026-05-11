<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\ProcurementRequest;
use App\Tests\TestHelpers\ProcurementRequestBuilder;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ControllerTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::ensureKernelShutdown();

        $this->client = self::createClient();

        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        self::assertInstanceOf(EntityManagerInterface::class, $entityManager);

        $this->entityManager = $entityManager;

        $this->deleteExistingRequests();
    }

    protected function deleteExistingRequests(): void
    {
        $this->entityManager->createQuery('DELETE FROM  App\Entity\ProcurementRequest procurementRequest')->execute();

        $this->entityManager->clear();
    }

    protected function saveProcurementRequest() : ProcurementRequest
    {
        $procurementRequest = ProcurementRequestBuilder::createDraft();

        $this->entityManager->persist($procurementRequest);
        $this->entityManager->flush();

        return $procurementRequest;
    }

}