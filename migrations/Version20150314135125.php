<?php

namespace Estaty\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150314135125 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'INSERT INTO `PropertyType` (
                `name`,
                `slug`
            )
            VALUES
                ("Apartment", "apartment"),
                ("House", "house")'
        );

        $this->addSql(
            'SET @apartmentId:= (SELECT `id` FROM `PropertyType` WHERE `slug` = "apartment");
            INSERT INTO `PropertyType` (
                `name`,
                `slug`,
                `parentId`
            )
            VALUES
                ("Room", "apartment-room", @apartmentId),
                ("Maisonette", "maisonette", @apartmentId),
                ("Studio", "studio", @apartmentId)'
        );

        $this->addSql(
            'SET @houseId:= (SELECT `id` FROM `PropertyType` WHERE `slug` = "house");
            INSERT INTO `PropertyType` (
                `name`,
                `slug`,
                `parentId`
            )
            VALUES
                ("Room", "house-room", @houseId),
                ("House floor", "house-floor", @houseId)'
        );
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('TRUNCATE `PropertyType`');
    }
}
