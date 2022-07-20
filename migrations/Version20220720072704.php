<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720072704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qg ADD missions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qg ADD CONSTRAINT FK_A42BAEB317C042CF FOREIGN KEY (missions_id) REFERENCES missions (id)');
        $this->addSql('CREATE INDEX IDX_A42BAEB317C042CF ON qg (missions_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qg DROP FOREIGN KEY FK_A42BAEB317C042CF');
        $this->addSql('DROP INDEX IDX_A42BAEB317C042CF ON qg');
        $this->addSql('ALTER TABLE qg DROP missions_id');
    }
}
