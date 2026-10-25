# Smile Lab - Laboratoire Dentaire

Système de gestion pour centre de création dentaire — Dashboard admin, suivi travaux, clients, facturation, caisse, stock, et plus.

## Stack Technique

- **Laravel 12** + MySQL
- **Livewire 4** — Composants dynamiques
- **Tailwind CSS 4** — Thème gold & black
- **Spatie Laravel Permission** — Rôles (Admin, Manager, Secrétaire, Assistante, Caisse, CAD/CAM)

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
# Configurer DB dans .env
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

Compte de démonstration (après le seed) :

- Email : `demo@smilelab.demo`
- Mot de passe : `SmileLab2026`

Le seed crée les rôles, le catalogue de prestations, un stock générique et les coordonnées fictives du laboratoire. Il ne crée aucun client, travail, facture ou bon de livraison.

## Base de données avec Docker (sans XAMPP)

Le projet inclut maintenant `docker-compose.yml` pour lancer MySQL + phpMyAdmin.

### 1) Lancer la base Docker

```bash
docker compose up -d
```

### 2) Mettre la config DB dans `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=ceralis
DB_USERNAME=ceralis
DB_PASSWORD=ceralis
```

### 3) Migrer et charger la démo vide

```bash
php artisan migrate --seed
```

### 4) phpMyAdmin (optionnel)

- URL: `http://localhost:8082`
- Serveur: `mysql` (ou `127.0.0.1` selon config)
- User: `ceralis`
- Password: `ceralis`

## Démarrage rapide

Les pages chargent le CSS/JS via **Vite**. Sans assets compilés, le navigateur attend le serveur Vite et la page reste blanche plusieurs minutes.

**Option A — Une seule commande (recommandé)**  
Après un premier `npm run build`, vous pouvez lancer uniquement Laravel :

```bash
npm run build   # une fois après clone/npm install
php artisan serve
# Ouvrir http://localhost:8000
```

**Option B — Développement avec rechargement à chaud**  
Lancer Laravel et le serveur Vite en parallèle (deux terminaux, ou `composer dev` si configuré) :

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

## Structure prévue

- **Dashboard** — KPIs, stats, graphiques
- **Travaux** — Ordres meds, CAD/CAM, suivi
- **Clients** — Patients, consultations
- **Facturation** — Factures (comptabilisée / non-comptabilisée)
- **Caisse** — 3 types (espèces, CB, virement)
- **Stock** — Matériaux, alertes
- **Fournisseurs** — Gestion fournisseurs

## Couleurs (Gold & Black)

- Background: `zinc-950`, `zinc-900`
- Accent: `amber-400`, `amber-500`
- Bordures: `amber-900/40`
