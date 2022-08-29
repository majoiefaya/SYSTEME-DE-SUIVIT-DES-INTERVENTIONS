<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823011338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9C9DB5AB');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FAD2CB34F');
        $this->addSql('DROP INDEX IDX_B6BD307FAD2CB34F ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F9C9DB5AB ON message');
        $this->addSql('ALTER TABLE message DROP message_sender_id, DROP message_receiver_id');
        $this->addSql('ALTER TABLE utilisateur DROP newsletter_validity');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD message_sender_id INT NOT NULL, ADD message_receiver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9C9DB5AB FOREIGN KEY (message_sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FAD2CB34F FOREIGN KEY (message_receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FAD2CB34F ON message (message_receiver_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9C9DB5AB ON message (message_sender_id)');
        $this->addSql('ALTER TABLE utilisateur ADD newsletter_validity TINYINT(1) DEFAULT NULL');
    }
}
