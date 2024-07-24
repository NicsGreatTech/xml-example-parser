<?php

declare(strict_types=1);

namespace NBorschke\Tests\Command;

use NBorschke\Entity\Catalog;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use NBorschke\Command\ImportCatalogCommand;

class ImportCatalogCommandTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $this->bootKernel();
        $this->runCommand('doctrine:database:drop', ['--force' => true]);
        $this->runCommand('doctrine:database:create');
        $this->runCommand('doctrine:migrations:migrate');

        $application = new Application('Test Application');
        $command = $this->getContainer()->get(ImportCatalogCommand::class);
        $application->add($command);
        $command = $application->find('nborschke:import-xml');

        $this->commandTester = new CommandTester($command);
        $this->entityManager = $this->getContainer()->get(EntityManagerInterface::class);
    }

    public function testExecute()
    {
        $this->commandTester->execute([
            'xmlFile' => 'tests/Fixtures/catalogtest.xml',
        ]);

        $output = $this->commandTester->getDisplay();
        $statusCode = $this->commandTester->getStatusCode();

        $this->assertStringContainsString('Data imported successfully.', $output);
        $this->assertEquals(0, $statusCode);

        $catalogRepository = $this->entityManager->getRepository(Catalog::class);
        $catalog = $catalogRepository->findOneBy(['entityId' => 340]);
        $this->assertNotNull($catalog);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->createQuery('DELETE FROM NBorschke\Entity\Catalog')->execute();
        static::ensureKernelShutdown();
        $this->commandTester = null;
        $this->entityManager->close();
        $this->entityManager = null;
    }

    private function runCommand(string $commandName, array $options = []): void
    {
        $command = $this->getContainer()->get('console.command_loader')->get($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($options);
    }
}