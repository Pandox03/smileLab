# Déploiement Smile Lab sur Hostinger

Démo vide : aucun client, travail ou facture. Utilisez une base de données neuve, réservée à ce dossier.

## Structure actuelle

Votre projet est dans **`public_html/Ceralis/`** (app, public, vendor, etc. sont dans ce dossier).

---

## Prochaines étapes (dans l’ordre)

### 1. Changer la racine du domaine (document root)

Pour que le site et les styles fonctionnent, le serveur doit utiliser le dossier **`public`** de Laravel comme racine web.

Dans **Hostinger** :

1. Allez dans **Domaines** (ou **Website** / **Gestion des domaines**).
2. Sélectionnez le domaine utilisé pour Smile Lab.
3. Trouvez **Document root** / **Racine du domaine** / **Root directory**.
4. Mettez : **`public_html/Ceralis/public`** (et non `public_html` ni `public_html/Ceralis`).
5. Enregistrez.

Résultat : quand on ouvre `https://votre-domaine.com`, le serveur exécute `public_html/Ceralis/public/index.php` et sert les assets depuis `public_html/Ceralis/public/build/`.

---

### 2. Fichier `.env` sur le serveur

Dans **`public_html/Ceralis/`**, vérifiez qu’il existe un fichier **`.env`** (copie de `.env.example` si besoin) avec au moins :

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com
```

(Remplacez `votre-domaine.com` par votre vrai domaine, **sans** slash à la fin.)

Générez une clé d’application si ce n’est pas fait :

```bash
php artisan key:generate
```

(Sur Hostinger : SSH ou « Terminal » dans le File Manager, en étant dans le dossier `Ceralis`.)

---

### 3. Dossier `public/build/` (styles et scripts)

Les CSS/JS sont compilés par Vite dans **`public/build/`**. Ce dossier doit être présent sur le serveur.

- En local, lancez : **`npm run build`**.
- Uploadez tout le contenu du dossier **`public/build/`** vers **`public_html/Ceralis/public/build/`** (fichiers `.js`, `.css`, `manifest.json`, etc.).

Sans ce dossier, les styles ne se chargeront pas.

---

### 4. Permissions et cache

Sur le serveur (SSH ou terminal Hostinger), dans le dossier `Ceralis` :

```bash
cd public_html/Ceralis
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Vérifiez que les dossiers **`storage`** et **`bootstrap/cache`** sont inscriptibles (par ex. 775 ou 755 selon ce qu’exige Hostinger).

---

## Si vous ne pouvez pas changer la document root

Un fichier **`.htaccess`** à la racine du projet (dans **`public_html/Ceralis/`**) redirige vers `public/`. Il doit être au même niveau que `app/`, `public/`, `vendor/`.  
Dans ce cas, la racine du domaine doit pointer vers **`public_html/Ceralis`** (et non vers `public`). Le `.htaccess` fera alors le reste (redirection vers `public/`).

---

## Étapes obligatoires

### 1. Compiler les assets (en local)

```bash
npm ci
npm run build
```

Cela crée/met à jour le dossier **`public/build/`** (fichiers `.js`, `.css`, `manifest.json`).

### 2. Envoyer sur le serveur

- Toute l’application (y compris `public/build/`).
- Ou au minimum : tout le projet **et** le contenu de `public/build/` (après `npm run build`).

### 3. Fichier `.env` sur le serveur

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://votre-domaine.com` (sans slash final)

### 4. Après chaque déploiement (si vous changez le JS/CSS)

```bash
npm run build
```

Puis re-uploader le dossier **`public/build/`** (ou tout le projet).

---

## Vérification rapide

- **Page blanche ou 500** : vérifier les logs dans `storage/logs/laravel.log` et les permissions (storage, bootstrap/cache en 755 ou 775).
- **Styles toujours absents** : vérifier en ouvrant une URL directe d’asset, ex. :  
  `https://votre-domaine.com/build/assets/app-XXXXX.css`  
  Si 404 : soit la racine du domaine n’est pas `public`, soit `public/build/` n’a pas été uploadé.
