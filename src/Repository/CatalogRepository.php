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
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
            INSERT INTO catalog (entity_id, category_name, sku, name, description, short_desc, price, link, image, brand, rating, caffeine_type, count, flavored, seasonal, in_stock, facebook, is_kcup)
            VALUES (:entityId, :categoryName, :sku, :name, :description, :shortDesc, :price, :link, :image, :brand, :rating, :caffeineType, :count, :flavored, :seasonal, :inStock, :facebook, :isKCup)
            ON DUPLICATE KEY UPDATE 
                category_name = VALUES(category_name),
                sku = VALUES(sku),
                name = VALUES(name),
                description = VALUES(description),
                short_desc = VALUES(short_desc),
                price = VALUES(price),
                link = VALUES(link),
                image = VALUES(image),
                brand = VALUES(brand),
                rating = VALUES(rating),
                caffeine_type = VALUES(caffeine_type),
                count = VALUES(count),
                flavored = VALUES(flavored),
                seasonal = VALUES(seasonal),
                in_stock = VALUES(in_stock),
                facebook = VALUES(facebook),
                is_kcup = VALUES(is_kcup)
        ';

        $statement = $connection->prepare($sql);
        $statement->executeQuery($catalog->toArray());
    }
}
