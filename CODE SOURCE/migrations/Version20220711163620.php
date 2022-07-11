<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220711163620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement ADD image VARCHAR(255) DEFAULT NULL, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur DROP is_verified');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3BF396750');
        $this->addSql('ALTER TABLE equipement DROP image, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD is_verified TINYINT(1) NOT NULL');
    }
}
