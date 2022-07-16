<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714100429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D761DFBCC46');
        $this->addSql('DROP INDEX IDX_880E0D761DFBCC46 ON admin');
        $this->addSql('ALTER TABLE admin DROP rapport_id');
        $this->addSql('ALTER TABLE rapport ADD admin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09C642B8210 ON rapport (admin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD rapport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D761DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('CREATE INDEX IDX_880E0D761DFBCC46 ON admin (rapport_id)');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C642B8210');
        $this->addSql('DROP INDEX IDX_BE34A09C642B8210 ON rapport');
        $this->addSql('ALTER TABLE rapport DROP admin_id');
    }
}
