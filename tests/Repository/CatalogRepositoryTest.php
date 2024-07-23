<?php

declare(strict_types=1);

namespace NBorschke\Tests\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use NBorschke\Entity\Catalog;
use NBorschke\Repository\CatalogRepository;
use PHPUnit\Framework\TestCase;

class CatalogRepositoryTest extends TestCase
{
    private $managerRegistry;

    private $entityManager;

    private $connection;

    private $catalogRepository;

    protected function setUp(): void
    {
        $this->connection = $this->createMock(Connection::class);

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->entityManager->method('getConnection')->willReturn($this->connection);

        $classMetadata = new ClassMetadata(Catalog::class);

        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->managerRegistry->method('getManagerForClass')->willReturn($this->entityManager);
        $this->managerRegistry->method('getManager')->willReturn($this->entityManager);
        $this->entityManager->method('getClassMetadata')->willReturn($classMetadata);

        $this->catalogRepository = new CatalogRepository($this->managerRegistry);
    }

    public function testInsertOrUpdate()
    {
        $catalog = new Catalog();
        $catalog
            ->setEntityId(999)
            ->setCategoryName('test_category')
            ->setSku('test_sku')
            ->setName('test_name')
            ->setDescription('test_description')
            ->setShortDesc('test_short_desc')
            ->setPrice(10.0)
            ->setLink('test_link')
            ->setImage('test_image')
            ->setBrand('test_brand')
            ->setRating('4.5')
            ->setCaffeineType('test_caffeine')
            ->setCount(1)
            ->setFlavored(false)
            ->setSeasonal(false)
            ->setInStock(true)
            ->setFacebook(true)
            ->setKcup(false);

        $statement = $this->createMock(\Doctrine\DBAL\Statement::class);
        $statement->expects($this->once())
            ->method('executeQuery')
            ->with($catalog->toArray());

        $this->connection->expects($this->once())
            ->method('prepare')
            ->willReturn($statement);

        $this->catalogRepository->insertOrUpdate($catalog);
    }
}