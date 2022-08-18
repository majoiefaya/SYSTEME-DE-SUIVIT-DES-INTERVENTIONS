<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220814133212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipe_technicien (equipe_id INT NOT NULL, technicien_id INT NOT NULL, INDEX IDX_BC1B76BD6D861B89 (equipe_id), INDEX IDX_BC1B76BD13457256 (technicien_id), PRIMARY KEY(equipe_id, technicien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipe_technicien ADD CONSTRAINT FK_BC1B76BD6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_technicien ADD CONSTRAINT FK_BC1B76BD13457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4C6D861B89');
        $this->addSql('DROP INDEX IDX_96282C4C6D861B89 ON technicien');
        $this->addSql('ALTER TABLE technicien DROP equipe_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE equipe_technicien');
        $this->addSql('ALTER TABLE technicien ADD equipe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_96282C4C6D861B89 ON technicien (equipe_id)');
    }
}
