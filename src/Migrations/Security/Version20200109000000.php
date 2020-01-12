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

namespace App\Migrations\Security;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200109000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create audit tables for Users and Profile.';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE security_profile_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_5b8479dec0fcd919bd53ebb9a033cf8e_idx (type), INDEX object_id_5b8479dec0fcd919bd53ebb9a033cf8e_idx (object_id), INDEX discriminator_5b8479dec0fcd919bd53ebb9a033cf8e_idx (discriminator), INDEX transaction_hash_5b8479dec0fcd919bd53ebb9a033cf8e_idx (transaction_hash), INDEX blame_id_5b8479dec0fcd919bd53ebb9a033cf8e_idx (blame_id), INDEX created_at_5b8479dec0fcd919bd53ebb9a033cf8e_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security_users_audit (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type VARCHAR(10) NOT NULL, object_id VARCHAR(255) NOT NULL, discriminator VARCHAR(255) DEFAULT NULL, transaction_hash VARCHAR(40) DEFAULT NULL, diffs JSON DEFAULT NULL, blame_id VARCHAR(255) DEFAULT NULL, blame_user VARCHAR(255) DEFAULT NULL, blame_user_fqdn VARCHAR(255) DEFAULT NULL, blame_user_firewall VARCHAR(100) DEFAULT NULL, ip VARCHAR(45) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX type_dd3865f0b346817707ff0cf82d1a28b4_idx (type), INDEX object_id_dd3865f0b346817707ff0cf82d1a28b4_idx (object_id), INDEX discriminator_dd3865f0b346817707ff0cf82d1a28b4_idx (discriminator), INDEX transaction_hash_dd3865f0b346817707ff0cf82d1a28b4_idx (transaction_hash), INDEX blame_id_dd3865f0b346817707ff0cf82d1a28b4_idx (blame_id), INDEX created_at_dd3865f0b346817707ff0cf82d1a28b4_idx (created_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE security_profile_audit');
        $this->addSql('DROP TABLE security_users_audit');
    }
}
