<?php

namespace Estaty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150208223734 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE City (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, countryId INT DEFAULT NULL, INDEX IDX_8D69AD0AFBA2A6B4 (countryId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, shortCode VARCHAR(255) NOT NULL, languageCode VARCHAR(255) NOT NULL, defaultCurrency VARCHAR(255) NOT NULL, areaUnit VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9CCEF0FAED0CC6C3 (shortCode), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Location (id INT AUTO_INCREMENT NOT NULL, countryId INT DEFAULT NULL, cityId INT DEFAULT NULL, postCode VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, latitude NUMERIC(9, 3) DEFAULT NULL, longitude NUMERIC(9, 3) DEFAULT NULL, INDEX IDX_A7E8EB9DFBA2A6B4 (countryId), INDEX IDX_A7E8EB9D7F99FC72 (cityId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE City');
        $this->addSql('DROP TABLE Country');
        $this->addSql('DROP TABLE Location');
    }
}
