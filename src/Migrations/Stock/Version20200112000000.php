<?php

declare(strict_types=1);

/**
 *
 * Household 2020 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2020 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2020 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Migrations\Stock;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200112000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create schemas to manage stock.';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stock_product (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', collection_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, ean LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', price DOUBLE PRECISION NOT NULL, expiring TINYINT(1) NOT NULL, best_before DATETIME NOT NULL, UNIQUE INDEX UNIQ_CAEC140E5E237E06 (name), INDEX IDX_CAEC140E514956FD (collection_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_product_collection (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', product_category_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, INDEX IDX_D451B6DEBE6903FD (product_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_inventory (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', product_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', location_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\', quantity INT NOT NULL, INDEX IDX_29B0ACDE4584665A (product_id), INDEX IDX_29B0ACDE64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_location (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_inventory_event (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', `index` INT NOT NULL, recorded DATETIME(6) NOT NULL COMMENT \'(DC2Type:datetime_micro)\', type VARCHAR(255) NOT NULL, payload LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', metadata LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id, `index`)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_product_category (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_product ADD CONSTRAINT FK_CAEC140E514956FD FOREIGN KEY (collection_id) REFERENCES stock_product_collection (id)');
        $this->addSql('ALTER TABLE stock_product_collection ADD CONSTRAINT FK_D451B6DEBE6903FD FOREIGN KEY (product_category_id) REFERENCES stock_product_category (id)');
        $this->addSql('ALTER TABLE stock_inventory ADD CONSTRAINT FK_29B0ACDE4584665A FOREIGN KEY (product_id) REFERENCES stock_product (id)');
        $this->addSql('ALTER TABLE stock_inventory ADD CONSTRAINT FK_29B0ACDE64D218E FOREIGN KEY (location_id) REFERENCES stock_location (id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock_inventory DROP FOREIGN KEY FK_29B0ACDE4584665A');
        $this->addSql('ALTER TABLE stock_product DROP FOREIGN KEY FK_CAEC140E514956FD');
        $this->addSql('ALTER TABLE stock_inventory DROP FOREIGN KEY FK_29B0ACDE64D218E');
        $this->addSql('ALTER TABLE stock_product_collection DROP FOREIGN KEY FK_D451B6DEBE6903FD');
        $this->addSql('DROP TABLE stock_product');
        $this->addSql('DROP TABLE stock_product_collection');
        $this->addSql('DROP TABLE stock_inventory');
        $this->addSql('DROP TABLE stock_location');
        $this->addSql('DROP TABLE stock_inventory_event');
        $this->addSql('DROP TABLE stock_product_category');
    }
}
