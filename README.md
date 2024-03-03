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

3. Créez un fichier `.env.` à la racine du projet . Mettez à jour les variables d'environnement appropriées telles que `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`, etc.

   Exemple de fichier `.env` :
   ```env
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=quai_antique
   DB_USERNAME=root
   DB_PASSWORD=password
   ```

4. Exécutez votre fichier SQL pour créer et alimenter la base de données.

5. Afin d avoir des données utilisateur pour tester les connexions , rendez vous à l adresse '"adresse_de_votre_serveur/back/UsersAdd/AddUsers.php'.
Celui ci execute un script inscrivant un super admin , un admin et un client avec le mot de passe hashé
vous pouvez modifier facilement les informations du fichier avant execution si désiré .
Ce fichier sert uniquement d exemple il peut ensuite être supprimé

### Frontend (HTML , CSS , JavaScript)


## Utilisation du projet

1. Assurez-vous que le backend est en cours d'exécution avec les configurations correctes.

2. Accédez à l'application dans votre navigateur à l'adresse indiquée (généralement http://localhost:8080).

3. Pour l envoie de mail en local , créez un compte sur mailtrap : https://mailtrap.io/ et récupérez vos informations de connexions

4. Pour la vérification anti-bot sur les formulaires , créez un compte sur google-recaptcha : https://www.google.com/recaptcha et récupérez vos clés client et serveur 
## Configurations de connexion

### Backend (PHP)

- **Host:** L'adresse du serveur de base de données (DB_HOST dans le fichier `.env`).
- **Port:** Le port utilisé par le serveur de base de données (DB_PORT dans le fichier `.env`).
- **Nom de la base de données:** Le nom de la base de données utilisée (DB_DATABASE dans le fichier `.env`).
- **Nom d'utilisateur:** Le nom d'utilisateur pour se connecter à la base de données (DB_USERNAME dans le fichier `.env`).
- **Mot de passe:** Le mot de passe pour se connecter à la base de données (DB_PASSWORD dans le fichier `.env`).

### Mailtrap (Test d'envoi de mails)

- **Host:** L'adresse SMTP de Mailtrap (SMTP_HOST dans le fichier `.env`).
- **Port:** Le port SMTP de Mailtrap (SMTP_PORT dans le fichier `.env`).
- **Nom d'utilisateur:** Le nom d'utilisateur SMTP de Mailtrap (SMTP_USERNAME dans le fichier `.env`).
- **Mot de passe:** Le mot de passe SMTP de Mailtrap (SMTP_PASSWORD dans le fichier `.env`).

### Google Recaptcha
- **clé client:** (RECAPTCHA_PUBLIC dans le fichier `.env`).
- **clé serveur:** (RECAPTCHA_PRIVATE dans le fichier `.env`) .

### Frontend 

- **URL de l'API Backend:** Configurez l'URL des API backend dans le fichier `.env` (API_URL)

   Exemple de fichier `.env` :
   ```env
   API_URL=http://localhost/back/api
   ```
### Backend 

- **URL de pour configurer le header Access-Control-Allow-Origin: des API :** Configurez l'URL  dans le fichier `.env` (WEB_URL)

   Exemple de fichier `.env` :
   ```env
   WEB_URL=http://localhost/Restaurant-Quai-Antique/pages/
   ```
















