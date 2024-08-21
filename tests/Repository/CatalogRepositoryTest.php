<?php

declare(strict_types=1);

namespace NBorschke\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use NBorschke\Entity\Catalog;
use NBorschke\Repository\CatalogRepository;
use PHPUnit\Framework\TestCase;

class CatalogRepositoryTest extends TestCase
{
    private $entityManager;
    private $catalogRepository;
    private $managerRegistry;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->managerRegistry->method('getManagerForClass')
            ->willReturn($this->entityManager);

        $classMetadata = new ClassMetadata(Catalog::class);
        $classMetadata->name = Catalog::class;

        $this->entityManager->method('getClassMetadata')
            ->willReturn($classMetadata);

        $this->catalogRepository = new CatalogRepository($this->managerRegistry);
    }

    public function testInsertNewCatalog()
    {
        $catalog = new Catalog();
        $catalog->setEntityId(999)
            ->setCategoryName('test_category')
            ->setSku('test_sku')
            ->setName('test_name')
            ->setDescription('test_description')
            ->setShortDesc('test_short_desc')
            ->setPrice(10.0)
            ->setLink('test_link')
            ->setImage('test_image')
            ->setBrand('test_brand')
            ->setRating(4)
            ->setCaffeineType('test_caffeine')
            ->setCount(1)
            ->setFlavored(false)
            ->setSeasonal(false)
            ->setInStock(true)
            ->setFacebook(true)
            ->setKCup(false);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($catalog);

        $this->catalogRepository->insertOrUpdate($catalog);
    }

    public function testUpdateExistingCatalog()
    {
        $existingCatalog = new Catalog();
        $existingCatalog->setEntityId(999)
            ->setCategoryName('existing_category');

        $this->catalogRepository = $this->getMockBuilder(CatalogRepository::class)
            ->setConstructorArgs([$this->managerRegistry])
            ->onlyMethods(['findOneBy'])
            ->getMock();

        $this->catalogRepository->method('findOneBy')
            ->with(['entityId' => 999])
            ->willReturn($existingCatalog);

        $updatedCatalog = new Catalog();
        $updatedCatalog->setEntityId(999)
            ->setCategoryName('updated_category')
            ->setSku('updated_sku')
            ->setName('updated_name')
            ->setDescription('updated_description')
            ->setShortDesc('updated_short_desc')
            ->setPrice(15.0)
            ->setLink('updated_link')
            ->setImage('updated_image')
            ->setBrand('updated_brand')
            ->setRating(5)
            ->setCaffeineType('updated_caffeine')
            ->setCount(2)
            ->setFlavored(true)
            ->setSeasonal(true)
            ->setInStock(false)
            ->setFacebook(false)
            ->setKCup(true);

        $this->catalogRepository->insertOrUpdate($updatedCatalog);
        $this->assertEquals('updated_category', $existingCatalog->getCategoryName());
        $this->assertEquals('updated_sku', $existingCatalog->getSku());
    }
}