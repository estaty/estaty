<?php

namespace Estaty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150210230336 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Property ADD price NUMERIC(12, 2) NOT NULL, ADD priceUsd NUMERIC(12, 2) NOT NULL, ADD currency VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE Country CHANGE defaultCurrency defaultCurrency VARCHAR(3) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Country CHANGE defaultCurrency defaultCurrency VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Property DROP price, DROP priceUsd, DROP currency');
    }
}
