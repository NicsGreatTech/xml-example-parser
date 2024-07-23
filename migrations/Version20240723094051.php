<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723094051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog (entity_id INT NOT NULL, category_name VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, short_desc LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, link VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, rating VARCHAR(255) NOT NULL, caffeine_type VARCHAR(255) NOT NULL, count INT NOT NULL, flavored TINYINT(1) NOT NULL, seasonal TINYINT(1) NOT NULL, in_stock TINYINT(1) NOT NULL, facebook TINYINT(1) NOT NULL, is_kcup TINYINT(1) NOT NULL, PRIMARY KEY(entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE catalog');
    }
}
