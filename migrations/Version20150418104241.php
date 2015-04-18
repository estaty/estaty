<?php

namespace Estaty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150418104241 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977FBA2A6B4 FOREIGN KEY (countryId) REFERENCES Country (id)');
        $this->addSql('CREATE INDEX IDX_2DA17977FBA2A6B4 ON User (countryId)');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E888376A4E7 FOREIGN KEY (primaryTypeId) REFERENCES PropertyType (id)');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E889BF49490 FOREIGN KEY (typeId) REFERENCES PropertyType (id)');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E8824B2CCF6 FOREIGN KEY (creatorId) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Property ADD CONSTRAINT FK_72847E8896D7286D FOREIGN KEY (locationId) REFERENCES Location (id)');
        $this->addSql('CREATE INDEX IDX_72847E8896D7286D ON Property (locationId)');
        $this->addSql('ALTER TABLE City ADD CONSTRAINT FK_8D69AD0AFBA2A6B4 FOREIGN KEY (countryId) REFERENCES Country (id)');
        $this->addSql('ALTER TABLE Location ADD CONSTRAINT FK_A7E8EB9D7F99FC72 FOREIGN KEY (cityId) REFERENCES City (id)');
        $this->addSql('ALTER TABLE PropertyType ADD CONSTRAINT FK_BB8A6EC610EE4CEE FOREIGN KEY (parentId) REFERENCES PropertyType (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE City DROP FOREIGN KEY FK_8D69AD0AFBA2A6B4');
        $this->addSql('ALTER TABLE Location DROP FOREIGN KEY FK_A7E8EB9D7F99FC72');
        $this->addSql('ALTER TABLE Property DROP FOREIGN KEY FK_72847E888376A4E7');
        $this->addSql('ALTER TABLE Property DROP FOREIGN KEY FK_72847E889BF49490');
        $this->addSql('ALTER TABLE Property DROP FOREIGN KEY FK_72847E8824B2CCF6');
        $this->addSql('ALTER TABLE Property DROP FOREIGN KEY FK_72847E8896D7286D');
        $this->addSql('DROP INDEX IDX_72847E8896D7286D ON Property');
        $this->addSql('ALTER TABLE PropertyType DROP FOREIGN KEY FK_BB8A6EC610EE4CEE');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977FBA2A6B4');
        $this->addSql('DROP INDEX IDX_2DA17977FBA2A6B4 ON User');
    }
}
