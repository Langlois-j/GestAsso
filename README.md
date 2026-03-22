# 🧗 GestionAsso

**ERP open source self-hosted pour clubs d'escalade affiliés FFME**

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v3-F59E0B)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?logo=php)](https://php.net)
[![Licence](https://img.shields.io/badge/Licence-AGPL--v3-blue)](LICENSE)
[![Club pilote](https://img.shields.io/badge/Club%20pilote-Desvr'Escalade-2d9e6b)](https://www.ffme.fr)

---

## 🎯 Présentation

GestionAsso est un ERP open source conçu pour les clubs d'escalade affiliés à la **FFME** (Fédération Française de la Montagne et de l'Escalade). Il digitalise et centralise la gestion administrative du club tout en respectant les exigences réglementaires françaises (RGPD, loi ACM, normes FFME).

**Principe :** 1 instance = 1 club — chaque club déploie sa propre instance indépendante.

**Club pilote :** Desvr'Escalade — 62240 Desvres (FFME)

---

## ✅ Modules V1

| Module | Description |
|--------|-------------|
| 👤 Membres | Fiches adhérents, licences FFME, passeport escalade, responsables légaux |
| 🎓 Diplômes | Gestion des diplômes encadrants, recyclages, habilitations présidentielles |
| ⚙️ Paramètres | Configuration API FFME, affiliation, rôles, SMTP |
| 🪢 EPI | Registre matériel, signalements, quarantaine, contrôle annuel |
| 📅 Créneaux | Séances récurrentes, responsable de séance, feuille de présence |
| 🏔️ Sorties | AST mineurs, déclaration DDCS, formation continue ACM |
| 🏛️ Bureau | Contrat d'engagement républicain, documents fondateurs |

> Comptabilité et gestion des accidents → reportées en V2.

---

## 🛠️ Stack technique

- **Backend :** Laravel 10 (PHP 8.1)
- **Admin panel :** Filament v3
- **Base de données :** MySQL 8 / MariaDB 10.6
- **Auth & rôles :** Laravel Sanctum + Spatie Laravel-Permission
- **Offline :** PWA légère + DomPDF
- **Chiffrement RGPD :** spatie/laravel-ciphersweet
- **Hébergement cible :** Mutualisé PHP (PlanetHoster The World)
- **Licence :** AGPL v3

---

## 🚀 Installation (développement local)

### Prérequis

- PHP 8.1+
- Composer
- MySQL / MariaDB
- [Laragon](https://laragon.org) (recommandé sur Windows)

### Étapes

```bash
# 1. Cloner le repo
git clone https://github.com/Langlois-j/GestAsso.git
cd GestAsso

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer .env (DB, SMTP, etc.)
# DB_DATABASE=gestion_asso_dev
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Créer la base de données puis migrer
php artisan migrate

# 6. Créer un compte admin
php artisan make:filament-user

# 7. Lancer le serveur
php artisan serve
```

Accès panel admin : `http://localhost:8000/admin`

---

## 🔐 Rôles utilisateurs

| Rôle | Description |
|------|-------------|
| `president` | Accès complet — dérogations — habilitations — déclarations |
| `encadrant` | Feuille présence — créneaux — sorties — signalement EPI |
| `gestionnaire_epi` | Registre EPI complet — clôture signalements — contrôle annuel |
| `membre` | Fiche personnelle — inscriptions — signalement EPI |
| `responsable_legal` | Sorties de son enfant — dépôt documents — signature AST |

Les rôles sont **cumulables** — les droits accordés sont l'union de tous les rôles actifs.

---

## 🔗 Intégration API FFME

GestionAsso s'appuie sur l'API officielle FFME (`https://api.core.myffme.fr/`) comme **source de vérité** pour les données fédérales (licences, passeports, diplômes). La saisie manuelle reste disponible en fallback si l'API est inaccessible.

> ⚠️ L'accès à l'API FFME nécessite des credentials club affilié (via myFFME).

---

## 📋 Conformité réglementaire

- **RGPD** — Registre de traitements V1 produit · chiffrement données sensibles (ciphersweet) · durées de conservation conformes
- **Loi ACM** — Gestion AST mineurs · déclaration DDCS (seuil 7 mineurs) · formation continue encadrants
- **FFME** — Passeport escalade · diplômes encadrants · affiliation annuelle

---

## 📁 Structure du projet

```
app/
├── Filament/          # Resources, Pages, Widgets Filament
├── Models/            # 19 modèles Eloquent
├── Services/          # FfmeApiService, etc.
database/
├── migrations/        # 19 migrations ordonnées
resources/
├── css/               # Charte graphique Desvr'Escalade
routes/
├── web.php
├── api.php
```

---

## 🎨 Charte graphique

```css
--blue:   #1d4e89   /* bleu faïence profond */
--accent: #2d9e6b   /* vert falaise Boulonnais */
--warm:   #c2622a   /* terre cuite / corde */
--chalk:  #f5f7fb   /* blanc calcaire */
/* Police : Plus Jakarta Sans */
```

---

## 🤝 Contribution

Ce projet suit la méthodologie **BMAD** (Breakthrough Method for Agile AI Driven Development).

Les contributions sont les bienvenues. Merci de respecter :
- La licence AGPL v3
- L'architecture 1 instance / 1 club
- Les contraintes RGPD documentées

---

## 📄 Licence

[GNU Affero General Public License v3.0](LICENSE)

---

*Développé avec ❤️ pour la communauté escalade FFME*
