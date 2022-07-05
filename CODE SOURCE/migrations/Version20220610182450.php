<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610182450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assistant_auto (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, nom_ass VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_A5ED2A9F642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, INDEX IDX_67F068BC19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, nom_equipe VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_2449BA15642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_intervention (equipe_id INT NOT NULL, intervention_id INT NOT NULL, INDEX IDX_5701568E6D861B89 (equipe_id), INDEX IDX_5701568E8EAE3863 (intervention_id), PRIMARY KEY(equipe_id, intervention_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, type_equipement_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, disponibilite VARCHAR(255) NOT NULL, nombre_utilisation INT NOT NULL, INDEX IDX_B8B4C6F3F082B869 (type_equipement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, assistant_auto_id INT DEFAULT NULL, nom_fonction VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_900D5BD21DE68B5 (assistant_auto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, zone_id INT DEFAULT NULL, date_intervention DATE DEFAULT NULL, date_prevue DATE NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, duree_intervention VARCHAR(255) DEFAULT NULL, INDEX IDX_D11814AB19EB6921 (client_id), INDEX IDX_D11814AB642B8210 (admin_id), INDEX IDX_D11814AB9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_equipement (intervention_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_FA49BCFE8EAE3863 (intervention_id), INDEX IDX_FA49BCFE806F0F5C (equipement_id), PRIMARY KEY(intervention_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_ass (id INT AUTO_INCREMENT NOT NULL, technicien_id INT DEFAULT NULL, intervention_id INT DEFAULT NULL, raisons VARCHAR(255) NOT NULL, INDEX IDX_C4AB84FF13457256 (technicien_id), INDEX IDX_C4AB84FF8EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, INDEX IDX_B6BD307FFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, raisons VARCHAR(255) NOT NULL, date_demande DATE NOT NULL, heure DATETIME NOT NULL, statut VARCHAR(255) DEFAULT NULL, duree INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, INDEX IDX_E04992AA1B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE points_geo (id INT AUTO_INCREMENT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_equipement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_points_geo (zone_id INT NOT NULL, points_geo_id INT NOT NULL, INDEX IDX_9765C8E19F2C3FAB (zone_id), INDEX IDX_9765C8E1EF9AF45D (points_geo_id), PRIMARY KEY(zone_id, points_geo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assistant_auto ADD CONSTRAINT FK_A5ED2A9F642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE equipe_intervention ADD CONSTRAINT FK_5701568E6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_intervention ADD CONSTRAINT FK_5701568E8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3F082B869 FOREIGN KEY (type_equipement_id) REFERENCES type_equipement (id)');
        $this->addSql('ALTER TABLE fonction ADD CONSTRAINT FK_900D5BD21DE68B5 FOREIGN KEY (assistant_auto_id) REFERENCES assistant_auto (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE intervention_equipement ADD CONSTRAINT FK_FA49BCFE8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_equipement ADD CONSTRAINT FK_FA49BCFE806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_ass ADD CONSTRAINT FK_C4AB84FF13457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id)');
        $this->addSql('ALTER TABLE intervention_ass ADD CONSTRAINT FK_C4AB84FF8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE zone_points_geo ADD CONSTRAINT FK_9765C8E19F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zone_points_geo ADD CONSTRAINT FK_9765C8E1EF9AF45D FOREIGN KEY (points_geo_id) REFERENCES points_geo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technicien ADD equipe_id INT DEFAULT NULL, ADD chef_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C150A48F1 FOREIGN KEY (chef_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_96282C4C6D861B89 ON technicien (equipe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96282C4C150A48F1 ON technicien (chef_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fonction DROP FOREIGN KEY FK_900D5BD21DE68B5');
        $this->addSql('ALTER TABLE equipe_intervention DROP FOREIGN KEY FK_5701568E6D861B89');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4C6D861B89');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4C150A48F1');
        $this->addSql('ALTER TABLE intervention_equipement DROP FOREIGN KEY FK_FA49BCFE806F0F5C');
        $this->addSql('ALTER TABLE equipe_intervention DROP FOREIGN KEY FK_5701568E8EAE3863');
        $this->addSql('ALTER TABLE intervention_equipement DROP FOREIGN KEY FK_FA49BCFE8EAE3863');
        $this->addSql('ALTER TABLE intervention_ass DROP FOREIGN KEY FK_C4AB84FF8EAE3863');
        $this->addSql('ALTER TABLE zone_points_geo DROP FOREIGN KEY FK_9765C8E1EF9AF45D');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3F082B869');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB9F2C3FAB');
        $this->addSql('ALTER TABLE zone_points_geo DROP FOREIGN KEY FK_9765C8E19F2C3FAB');
        $this->addSql('DROP TABLE assistant_auto');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_intervention');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_equipement');
        $this->addSql('DROP TABLE intervention_ass');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE points_geo');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE type_equipement');
        $this->addSql('DROP TABLE zone');
        $this->addSql('DROP TABLE zone_points_geo');
        $this->addSql('DROP INDEX IDX_96282C4C6D861B89 ON technicien');
        $this->addSql('DROP INDEX UNIQ_96282C4C150A48F1 ON technicien');
        $this->addSql('ALTER TABLE technicien DROP equipe_id, DROP chef_id');
    }
}
