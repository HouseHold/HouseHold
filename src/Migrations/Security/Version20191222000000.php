<?php

declare(strict_types=1);

/**
 *
 * Household 2019 — NOTICE OF LICENSE
 * This source file is released under commercial license by copyright holders.
 *
 * @copyright 2017-2019 (c) Niko Granö (https://granö.fi)
 * @copyright 2014-2019 (c) IronLions (https://ironlions.fi)
 *
 */

namespace App\Migrations\Security;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191222000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update Security Tables.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE security_profile CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE security_profile ADD CONSTRAINT FK_ECBCA112A76ED395 FOREIGN KEY (user_id) REFERENCES security_users (id)');
        $this->addSql('ALTER TABLE security_users CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE salt salt VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE security_profile DROP FOREIGN KEY FK_ECBCA112A76ED395');
        $this->addSql('ALTER TABLE security_profile CHANGE user_id user_id INT DEFAULT NULL, CHANGE state state VARCHAR(255) CHARACTER SET utf8 DEFAULT \'\'\'NULL\'\'\' COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE security_users CHANGE password password VARCHAR(255) CHARACTER SET utf8 DEFAULT \'\'\'NULL\'\'\' COLLATE `utf8_unicode_ci`, CHANGE salt salt VARCHAR(255) CHARACTER SET utf8 DEFAULT \'\'\'NULL\'\'\' COLLATE `utf8_unicode_ci`');
    }
}
