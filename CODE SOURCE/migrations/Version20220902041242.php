<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220902041242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action_infos (id INT AUTO_INCREMENT NOT NULL, creer_par VARCHAR(255) NOT NULL, creer_le DATE NOT NULL, modifier_par VARCHAR(255) DEFAULT NULL, modifier_le DATE DEFAULT NULL, enable TINYINT(1) NOT NULL, supprimer_par VARCHAR(255) DEFAULT NULL, supprimer_le DATE DEFAULT NULL, active TINYINT(1) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, fonction VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assistant_auto (id INT AUTO_INCREMENT NOT NULL, admin_id INT DEFAULT NULL, nom_ass VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, INDEX IDX_A5ED2A9F642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendar (id INT AUTO_INCREMENT NOT NULL, intervention_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) NOT NULL, border_color VARCHAR(7) NOT NULL, text_color VARCHAR(7) NOT NULL, UNIQUE INDEX UNIQ_6EA9A1468EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, intervention_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATE NOT NULL, INDEX IDX_67F068BC19EB6921 (client_id), INDEX IDX_67F068BC8EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT NOT NULL, fonction VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT NOT NULL, admin_id INT DEFAULT NULL, nom_equipe VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_2449BA15642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_intervention (equipe_id INT NOT NULL, intervention_id INT NOT NULL, INDEX IDX_5701568E6D861B89 (equipe_id), INDEX IDX_5701568E8EAE3863 (intervention_id), PRIMARY KEY(equipe_id, intervention_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_technicien (equipe_id INT NOT NULL, technicien_id INT NOT NULL, INDEX IDX_BC1B76BD6D861B89 (equipe_id), INDEX IDX_BC1B76BD13457256 (technicien_id), PRIMARY KEY(equipe_id, technicien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT NOT NULL, type_equipement_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, disponibilite VARCHAR(255) NOT NULL, nombre_utilisation INT NOT NULL, image VARCHAR(255) DEFAULT NULL, quantite_equipement INT NOT NULL, INDEX IDX_B8B4C6F3F082B869 (type_equipement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonction (id INT AUTO_INCREMENT NOT NULL, assistant_auto_id INT DEFAULT NULL, nom_fonction VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_900D5BD21DE68B5 (assistant_auto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT NOT NULL, client_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, zone_id INT DEFAULT NULL, date_intervention DATE DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, duree_intervention VARCHAR(255) DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, date_debut_intervention DATETIME DEFAULT NULL, date_fin_intervention DATETIME DEFAULT NULL, INDEX IDX_D11814AB19EB6921 (client_id), INDEX IDX_D11814AB642B8210 (admin_id), INDEX IDX_D11814AB9F2C3FAB (zone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_equipement (intervention_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_FA49BCFE8EAE3863 (intervention_id), INDEX IDX_FA49BCFE806F0F5C (equipement_id), PRIMARY KEY(intervention_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_ass (id INT AUTO_INCREMENT NOT NULL, technicien_id INT DEFAULT NULL, intervention_id INT DEFAULT NULL, raisons VARCHAR(255) NOT NULL, INDEX IDX_C4AB84FF13457256 (technicien_id), INDEX IDX_C4AB84FF8EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, message_sender_id INT DEFAULT NULL, message_receiver_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, INDEX IDX_B6BD307F9C9DB5AB (message_sender_id), INDEX IDX_B6BD307FAD2CB34F (message_receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permission (id INT AUTO_INCREMENT NOT NULL, employe_id INT DEFAULT NULL, raisons VARCHAR(255) NOT NULL, date_demande DATE NOT NULL, heure DATETIME NOT NULL, statut VARCHAR(255) DEFAULT NULL, duree INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, INDEX IDX_E04992AA1B65292 (employe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE points_geo (id INT AUTO_INCREMENT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id INT NOT NULL, employe_id INT NOT NULL, admin_id INT DEFAULT NULL, intervention_id INT DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, date_envoi DATE DEFAULT NULL, fichier VARCHAR(255) DEFAULT NULL, sujet_rapport VARCHAR(255) NOT NULL, statut_rapport VARCHAR(255) NOT NULL, heure_envoi TIME DEFAULT NULL, INDEX IDX_BE34A09C1B65292 (employe_id), INDEX IDX_BE34A09C642B8210 (admin_id), INDEX IDX_BE34A09C8EAE3863 (intervention_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT NOT NULL, destinataire_tache_id INT NOT NULL, titre_tache VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) NOT NULL, fichier VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_93872075C3609AD3 (destinataire_tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technicien (id INT NOT NULL, chef_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_96282C4C150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_equipement (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, quantite_type_equipement INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age INT NOT NULL, sexe VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', image VARCHAR(255) DEFAULT NULL, code VARCHAR(255) NOT NULL, newsletter TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone_points_geo (zone_id INT NOT NULL, points_geo_id INT NOT NULL, INDEX IDX_9765C8E19F2C3FAB (zone_id), INDEX IDX_9765C8E1EF9AF45D (points_geo_id), PRIMARY KEY(zone_id, points_geo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assistant_auto ADD CONSTRAINT FK_A5ED2A9F642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE calendar ADD CONSTRAINT FK_6EA9A1468EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_intervention ADD CONSTRAINT FK_5701568E6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_intervention ADD CONSTRAINT FK_5701568E8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_technicien ADD CONSTRAINT FK_BC1B76BD6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_technicien ADD CONSTRAINT FK_BC1B76BD13457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3F082B869 FOREIGN KEY (type_equipement_id) REFERENCES type_equipement (id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fonction ADD CONSTRAINT FK_900D5BD21DE68B5 FOREIGN KEY (assistant_auto_id) REFERENCES assistant_auto (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABBF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_equipement ADD CONSTRAINT FK_FA49BCFE8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_equipement ADD CONSTRAINT FK_FA49BCFE806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_ass ADD CONSTRAINT FK_C4AB84FF13457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id)');
        $this->addSql('ALTER TABLE intervention_ass ADD CONSTRAINT FK_C4AB84FF8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9C9DB5AB FOREIGN KEY (message_sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FAD2CB34F FOREIGN KEY (message_receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE permission ADD CONSTRAINT FK_E04992AA1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DEBF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CBF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075C3609AD3 FOREIGN KEY (destinataire_tache_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4C150A48F1 FOREIGN KEY (chef_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE technicien ADD CONSTRAINT FK_96282C4CBF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_equipement ADD CONSTRAINT FK_A5B710D6BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3BF396750 FOREIGN KEY (id) REFERENCES action_infos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zone_points_geo ADD CONSTRAINT FK_9765C8E19F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE zone_points_geo ADD CONSTRAINT FK_9765C8E1EF9AF45D FOREIGN KEY (points_geo_id) REFERENCES points_geo (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE assistant_auto DROP FOREIGN KEY FK_A5ED2A9F642B8210');
        $this->addSql('ALTER TABLE calendar DROP FOREIGN KEY FK_6EA9A1468EAE3863');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC19EB6921');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC8EAE3863');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9BF396750');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15642B8210');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15BF396750');
        $this->addSql('ALTER TABLE equipe_intervention DROP FOREIGN KEY FK_5701568E6D861B89');
        $this->addSql('ALTER TABLE equipe_intervention DROP FOREIGN KEY FK_5701568E8EAE3863');
        $this->addSql('ALTER TABLE equipe_technicien DROP FOREIGN KEY FK_BC1B76BD6D861B89');
        $this->addSql('ALTER TABLE equipe_technicien DROP FOREIGN KEY FK_BC1B76BD13457256');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3F082B869');
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_B8B4C6F3BF396750');
        $this->addSql('ALTER TABLE fonction DROP FOREIGN KEY FK_900D5BD21DE68B5');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB19EB6921');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB642B8210');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB9F2C3FAB');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814ABBF396750');
        $this->addSql('ALTER TABLE intervention_equipement DROP FOREIGN KEY FK_FA49BCFE8EAE3863');
        $this->addSql('ALTER TABLE intervention_equipement DROP FOREIGN KEY FK_FA49BCFE806F0F5C');
        $this->addSql('ALTER TABLE intervention_ass DROP FOREIGN KEY FK_C4AB84FF13457256');
        $this->addSql('ALTER TABLE intervention_ass DROP FOREIGN KEY FK_C4AB84FF8EAE3863');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9C9DB5AB');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FAD2CB34F');
        $this->addSql('ALTER TABLE permission DROP FOREIGN KEY FK_E04992AA1B65292');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DEBF396750');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C1B65292');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C642B8210');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C8EAE3863');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CBF396750');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075C3609AD3');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075BF396750');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4C150A48F1');
        $this->addSql('ALTER TABLE technicien DROP FOREIGN KEY FK_96282C4CBF396750');
        $this->addSql('ALTER TABLE type_equipement DROP FOREIGN KEY FK_A5B710D6BF396750');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3BF396750');
        $this->addSql('ALTER TABLE zone_points_geo DROP FOREIGN KEY FK_9765C8E19F2C3FAB');
        $this->addSql('ALTER TABLE zone_points_geo DROP FOREIGN KEY FK_9765C8E1EF9AF45D');
        $this->addSql('DROP TABLE action_infos');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE assistant_auto');
        $this->addSql('DROP TABLE calendar');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_intervention');
        $this->addSql('DROP TABLE equipe_technicien');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_equipement');
        $this->addSql('DROP TABLE intervention_ass');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE permission');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE points_geo');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('DROP TABLE type_equipement');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE zone');
        $this->addSql('DROP TABLE zone_points_geo');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
