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

final class Version20200315000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add support for product manufacturer.';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE stock_product_manufacturer (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_product ADD manufacturer_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid_binary)\' AFTER collection_id');
        $this->addSql('ALTER TABLE stock_product ADD CONSTRAINT FK_CAEC140EA23B42D FOREIGN KEY (manufacturer_id) REFERENCES stock_product_manufacturer (id)');
        $this->addSql('CREATE INDEX IDX_CAEC140EA23B42D ON stock_product (manufacturer_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE stock_product DROP FOREIGN KEY FK_CAEC140EA23B42D');
        $this->addSql('DROP INDEX IDX_CAEC140EA23B42D ON stock_product');
        $this->addSql('ALTER TABLE stock_product DROP manufacturer_id');
        $this->addSql('DROP TABLE stock_product_manufacturer');
    }
}
