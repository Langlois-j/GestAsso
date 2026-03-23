# 🏛️ GestAsso

**ERP open source self-hosted pour la gestion associative**

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-v3-F59E0B)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?logo=php)](https://php.net)
[![Licence](https://img.shields.io/badge/Licence-AGPL--v3-blue)](LICENSE)

---

## 🎯 Présentation

GestAsso est un ERP open source conçu pour les associations sportives et culturelles.
Il digitalise et centralise la gestion administrative tout en respectant les exigences
réglementaires françaises (RGPD, loi ACM).

**Principe :** 1 instance = 1 association — chaque structure déploie sa propre instance indépendante.

---

## ✅ Modules V1

| Module | Description |
|--------|-------------|
| 👤 Membres | Fiches adhérents, licences, responsables légaux |
| 🎓 Diplômes | Gestion des diplômes encadrants, recyclages, habilitations |
| ⚙️ Paramètres | Configuration, rôles, SMTP |
| 🪢 EPI | Registre matériel, signalements, quarantaine, contrôle annuel |
| 📅 Créneaux | Séances récurrentes, responsable de séance, feuille de présence |
| 🏔️ Sorties | Autorisations mineurs, déclarations, formation continue |
| 🏛️ Bureau | Documents officiels, engagement républicain |

> Comptabilité et gestion des accidents → V2.

---

## 🛠️ Stack technique

- **Backend :** Laravel 10 (PHP 8.1)
- **Admin panel :** Filament v3
- **Base de données :** MySQL 8 / MariaDB 10.6
- **Auth & rôles :** Laravel Sanctum + Spatie Laravel-Permission
- **Offline :** PWA légère + DomPDF
- **Chiffrement RGPD :** spatie/laravel-ciphersweet
- **Hébergement cible :** Mutualisé PHP
- **Licence :** AGPL v3

---

## 🚀 Installation

### Prérequis

- PHP 8.1+
- Composer
- MySQL / MariaDB

### Étapes
```bash
git clone https://github.com/Langlois-j/GestAsso.git
cd GestAsso
composer install
cp .env.example .env
php artisan key:generate
# Configurer .env (DB, SMTP...)
php artisan migrate
php artisan make:filament-user
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
| `responsable_legal` | Sorties de son enfant — dépôt documents — signatures |

Les rôles sont **cumulables** — les droits accordés sont l'union de tous les rôles actifs.

---

## 📋 Conformité réglementaire

- **RGPD** — Chiffrement données sensibles · durées de conservation conformes
- **Loi ACM** — Gestion autorisations mineurs · seuils déclaratifs · formation continue
- **AGPL v3** — Toute modification redistribuée doit rester open source

---

## 📄 Licence

[GNU Affero General Public License v3.0](LICENSE)

---

*Développé avec ❤️ pour la communauté associative*
