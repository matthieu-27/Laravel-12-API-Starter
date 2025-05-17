# Laravel 12 API Starter

Un starter prêt à l'emploi pour créer une API avec Laravel 12, incluant Fortify pour l'authentification et Sanctum pour l'authentification des API.

## Fonctionnalités

- **Laravel 12** : Le dernier framework PHP pour le développement d'applications web.
- **Fortify** : Pour l'authentification des utilisateurs.
- **Sanctum** : Pour l'authentification des API.
- **Réponses en JSON** : Les réponses de l'API sont formatées en JSON.

## Prérequis

- PHP >= 8.1
- Composer
- Base de données (MySQL, PostgreSQL, SQLite, etc.)
- Node.js (pour les dépendances frontend si nécessaire)

## Installation

1. Clonez le dépôt :

```bash
git clone https://github.com/votre-utilisateur/laravel-12-api-starter.git
cd laravel-12-api-starter
````
   
2. Installez les dépendances PHP :

```bash
composer install
````

3. Copiez le fichier d'environnement et configurez-le :

```bash
cp .env.example .env
````
   
4. Configurez votre fichier .env avec les informations de votre base de données et d'autres paramètres nécessaires.

Générez la clé d'application :
```bash
php artisan key:generate
````

5. Exécutez les migrations pour créer les tables de la base de données :

```bash
php artisan migrate
````
   
(Optionnel) Installez les dépendances frontend si nécessaire :

```bash
npm install
npm run dev
````

## Utilisation

Démarrez le serveur de développement :

```bash
php artisan serve
````
Accédez à l'API via http://localhost:8000.

## Configuration de Fortify et Sanctum

Fortify est déjà configuré pour gérer l'authentification des utilisateurs. Vous pouvez personnaliser les vues et les routes selon vos besoins.
Sanctum est configuré pour l'authentification des API. Assurez-vous de configurer les middleware appropriés pour protéger vos routes API.

## Exemples de requêtes API

Voici quelques exemples de requêtes API que vous pouvez utiliser :

**Inscription :**

```http
POST /api/register
Content-Type: application/json
````

```json
{
"name": "John Doe",
"email": "john@example.com",
"password": "password",
"password_confirmation": "password"
}
````
    
**Connexion :**

```http
POST /api/login
Content-Type: application/json
````

```json
{
"email": "john@example.com",
"password": "password"
}
````

**Accéder à une ressource protégée :**

```http
GET /api/user
Authorization: Bearer {token}
````

## Contribution

Les contributions sont les bienvenues ! Veuillez ouvrir une issue ou soumettre une pull request pour toute amélioration ou correction de bug.

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.
