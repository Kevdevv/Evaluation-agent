<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220718133312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD created_at DATETIME NULL DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD birth DATETIME NULL DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD speciality VARCHAR(255) NOT NULL, ADD matricule INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP lastname, DROP firstname, DROP created_at, DROP birth, DROP speciality, DROP matricule');
    }
}
