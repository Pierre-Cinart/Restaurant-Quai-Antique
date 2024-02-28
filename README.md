# Projet Quai Antique

Bienvenue dans le projet Quai Antique. Ce projet est réalisé dans le cadre d'un ecf de développement web
Le restaurant quai antique est un restaurant fictif

## Configuration de l'environnement

### Backend (PHP)

1. Assurez-vous d'avoir [Composer](https://getcomposer.org/) installé sur votre machine.
2. À la racine du projet exécutez :
    ```bash
    composer install
    ``` 
    pour installer les dépendances PHP.
3. À la racine de votre projet, exécutez 
    ```bash
    composer require phpmailer/phpmailer
    ``` 
    pour installer PHPMailer, une bibliothèque pour l'envoi d'e-mails en PHP
4. À la racine de votre projet, exécutez 
    ```bash
    composer require vlucas/phpdotenv
    ``` 
    pour pouvoir utiliser le fichier .env
5. Créez un fichier à la racine du projet  `.env.` . Mettez à jour les variables d'environnement appropriées telles que `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, etc.

   Exemple de fichier `.env` :
   ```env
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=quai_antique
   DB_USERNAME=root
   DB_PASSWORD=password
   ```

4. Exécutez votre fichier SQL pour créer et alimenter la base de données.
5. Afin d avoir des données utilisateur pour tester les connexions , rendez vous à l adresse '"adresse_de_votre_serveur/back/Exemple/AddUsers.php'.
Celui ci execute un script inscrivant un super admin , un admin et un client avec le mot de passe hashé
vous pouvez modifier facilement les informations du fichier avant execution si désiré .
Ce fichier sert uniquement d exemple il peut ensuite être supprimé

### Frontend (Vue.js)

1. Assurez-vous d'avoir [Node.js](https://nodejs.org/) installé sur votre machine.
2. Rendez vous dans le dossier front , installez Vue.js en exécutant la commande suivante dans votre terminal :

    ```bash
    npm install -g vue
    ```

3. Puis installez Vue CLI en exécutant la commande suivante :

    ```bash
    npm install -g @vue/cli
    ```

4. Ensuite installez Bootstrap en exécutant la commande suivante :
    ```bash
    npm install bootstrap
    ```
5. Enfin installer les dépendances Vue.js , exécutez :

    ```bash
    npm install 
    ```

## Utilisation du projet

1. Assurez-vous que le backend est en cours d'exécution avec les configurations correctes.
2. Exécutez le frontend avec `npm run serve` dans le dossier `front`.
3. Accédez à l'application dans votre navigateur à l'adresse indiquée (généralement http://localhost:8080).

## Configurations de connexion

### Backend (PHP)

- **Host:** L'adresse du serveur de base de données (DB_HOST dans le fichier `.env`).
- **Port:** Le port utilisé par le serveur de base de données (DB_PORT dans le fichier `.env`).
- **Nom de la base de données:** Le nom de la base de données utilisée (DB_DATABASE dans le fichier `.env`).
- **Nom d'utilisateur:** Le nom d'utilisateur pour se connecter à la base de données (DB_USERNAME dans le fichier `.env`).
- **Mot de passe:** Le mot de passe pour se connecter à la base de données (DB_PASSWORD dans le fichier `.env`).

### Frontend (Vue.js)

- **URL de l'API Backend:** Assurez-vous que l'URL de l'API backend est correctement configurée dans le fichier `.env` du frontend.

   Exemple de fichier `.env` :
   ```env
   VUE_APP_API_URL=http://localhost/back/api
   ```








