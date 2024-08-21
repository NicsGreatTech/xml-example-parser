<?php

declare(strict_types=1);

namespace NBorschke\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use NBorschke\Entity\Catalog;

/**
 * @extends ServiceEntityRepository<Catalog>
 */
class CatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    public function insertOrUpdate(Catalog $catalog): void
    {
        $entityManager = $this->getEntityManager();
        $existingCatalog = $this->findOneBy(['entityId' => $catalog->getEntityId()]);

        if ($existingCatalog) {
            $existingCatalog
                ->setCategoryName($catalog->getCategoryName())
                ->setSku($catalog->getSku())
                ->setName($catalog->getName())
                ->setDescription($catalog->getDescription())
                ->setShortDesc($catalog->getShortDesc())
                ->setPrice($catalog->getPrice())
                ->setLink($catalog->getLink())
                ->setImage($catalog->getImage())
                ->setBrand($catalog->getBrand())
                ->setRating($catalog->getRating())
                ->setCaffeineType($catalog->getCaffeineType())
                ->setCount($catalog->getCount())
                ->setFlavored($catalog->isFlavored())
                ->setSeasonal($catalog->isSeasonal())
                ->setInStock($catalog->isInStock())
                ->setFacebook($catalog->isFacebook())
                ->setKCup($catalog->isKCup());
        } else {
            $entityManager->persist($catalog);
        }
    }
}
