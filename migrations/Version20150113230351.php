<?php

namespace Estaty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150113230351 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_FACEBOOK_UID ON User (facebookUid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_GOOGLE_UID ON User (googleUid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_GITHUB_UID ON User (githubUid)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_FACEBOOK_UID ON User');
        $this->addSql('DROP INDEX UNIQ_GOOGLE_UID ON User');
        $this->addSql('DROP INDEX UNIQ_GITHUB_UID ON User');
    }
}
