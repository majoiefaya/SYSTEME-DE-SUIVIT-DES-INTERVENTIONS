
# SDI – Système de Suivi des Interventions

> Application Symfony MVC permettant de gérer l’ensemble des interventions techniques, les ressources humaines, matérielles, et la production de rapports dans un environnement multi-utilisateurs sécurisé.

<p align="center">
  <img src="https://img.shields.io/badge/Symfony-000000?style=flat-square&logo=symfony&logoColor=white" alt="Symfony"/>
  <img src="https://img.shields.io/badge/PHP-%3E=8.1-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-00758F?style=flat-square&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/Webpack-1C78C0?style=flat-square&logo=webpack&logoColor=white" alt="Webpack"/>
  <img src="https://img.shields.io/badge/Twig-20B2AA?style=flat-square&logo=twig&logoColor=white" alt="Twig"/>
  <img src="https://img.shields.io/badge/Architecture-MVC-critical?style=flat-square" alt="MVC"/>
  <img src="https://img.shields.io/badge/Status-En%20développement-yellow?style=flat-square" alt="Statut"/>
</p>

<h3 align="center">• • •</h3>

## Description

Le SDI est une solution complète développée en Symfony pour suivre, planifier et gérer les interventions au sein d’un service technique. L’application intègre la gestion :
- des comptes utilisateurs (administrateur, technicien, personnel, client),
- des interventions et de leur géolocalisation,
- des équipements techniques,
- des rapports d’intervention,
- et même des assistants intelligents.

<h3 align="center">• • •</h3>

## Prérequis

- PHP ≥ 8.1
- Composer
- Symfony CLI
- Node.js + npm (pour Webpack Encore)
- MySQL ou MariaDB

<h3 align="center">• • •</h3>

## Étapes d'installation locale

```bash
# 1. Cloner le dépôt GitHub
git clone https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS.git
cd SYSTEME-DE-SUIVIT-DES-INTERVENTIONS

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances front-end (Webpack Encore)
npm install

# 4. Copier et configurer les variables d’environnement
cp .env .env.local
# (modifie les informations de connexion à la base de données si besoin)

# 5. Créer la base de données
php bin/console doctrine:database:create

# 6. Générer les fichiers de migration (si entités modifiées ou ajoutées)
php bin/console doctrine:migrations:diff

# 7. Appliquer les migrations
php bin/console doctrine:migrations:migrate

# 8. Compiler les assets front-end
npm run dev

# 9. Lancer le serveur local Symfony
symfony server:start ou symfony serve
```

<h3 align="center">• • •</h3>

### Résultat

Ton projet est maintenant accessible sur :
```
http://localhost:8000
```

En cas d’erreur liée aux fichiers CSS/JS, assure-toi que la commande `npm run dev` a bien généré le dossier `/public/build/`.

<h3 align="center">• • •</h3>

## Captures d’écran

<p align="center">
  <table>
    <tr>
      <td align="center">Accueil Admin<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/Admin_accueil.png?raw=true" width="300"/>
      </td>
      <td align="center">Rapport d’intervention<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/Rapports_sdi_admin.png?raw=true" width="300"/>
      </td>
      <td align="center">Dashboard Employé<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/Employe_dashboard.png?raw=true" width="300"/>
      </td>
      <td align="center">Connexion<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/connexion_page.png?raw=true" width="300"/>
      </td>
    </tr>
    <tr>
      <td align="center">Client - Interventions terminées<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/client_intervention_terminé.png?raw=true" width="300"/>
      </td>
      <td align="center">Création d'intervention<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/create_intervention.png?raw=true" width="300"/>
      </td>
      <td align="center">Équipements<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/equipements_admin.png?raw=true" width="300"/>
      </td>
      <td align="center">Inscription<br/>
        <img src="https://github.com/majoiefaya/SYSTEME-DE-SUIVIT-DES-INTERVENTIONS/blob/main/assets/images/inscription_page_1.png?raw=true" width="300"/>
      </td>
    </tr>
  </table>
</p>

<h3 align="center">• • •</h3>

## Licence

Projet développé dans le cadre personnel.  
© 2025 Faya Lidao Majoie & Bagna Prince.

<h3 align="center">• • •</h3>

## ☕ Me soutenir

<p align="center">
  <a href="https://buymeacoffee.com/majoiefaya" target="_blank" rel="noopener noreferrer">
    <img src="https://img.shields.io/badge/Buy%20Me%20a%20Coffee-ffdd00?style=flat-square&logo=buymeacoffee&logoColor=black" alt="Buy Me a Coffee"/>
  </a>
</p>
