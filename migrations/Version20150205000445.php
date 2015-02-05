<?php

namespace Estaty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150205000445 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE PropertyType (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, parentId INT DEFAULT NULL, UNIQUE INDEX UNIQ_BB8A6EC6989D9B62 (slug), UNIQUE INDEX UNIQ_BB8A6EC610EE4CEE (parentId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PropertyType ADD CONSTRAINT FK_BB8A6EC610EE4CEE FOREIGN KEY (parentId) REFERENCES PropertyType (id)');
        $this->addSql('ALTER TABLE Property ADD primaryTypeId INT DEFAULT NULL, ADD typeId INT DEFAULT NULL, ADD creatorId INT DEFAULT NULL, DROP type, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E888376A4E7 FOREIGN KEY (primaryTypeId) REFERENCES PropertyType (id)');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E889BF49490 FOREIGN KEY (typeId) REFERENCES PropertyType (id)');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E8824B2CCF6 FOREIGN KEY (creatorId) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_72847E888376A4E7 ON Property (primaryTypeId)');
        $this->addSql('CREATE INDEX IDX_72847E889BF49490 ON Property (typeId)');
        $this->addSql('CREATE INDEX IDX_72847E8824B2CCF6 ON Property (creatorId)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Property DROP FOREIGN KEY FK_72847E888376A4E7');
        $this->addSql('ALTER TABLE Property DROP FOREIGN KEY FK_72847E889BF49490');
        $this->addSql('ALTER TABLE PropertyType DROP FOREIGN KEY FK_BB8A6EC610EE4CEE');
        $this->addSql('DROP TABLE PropertyType');
        $this->addSql('DROP INDEX IDX_72847E888376A4E7 ON Property');
        $this->addSql('DROP INDEX IDX_72847E889BF49490 ON Property');
        $this->addSql('DROP INDEX IDX_72847E8824B2CCF6 ON Property');
        $this->addSql('ALTER TABLE Property ADD type VARCHAR(255) NOT NULL, DROP primaryTypeId, DROP typeId, DROP creatorId, CHANGE name name VARCHAR(255) NOT NULL');
    }
}
