<?php

//chemin de vendor autoload
require_once __DIR__ . '/../../vendor/autoload.php';

// Chemin du fichier .env
$dotenvPath = __DIR__ . '/../../';

// Vérifier si le fichier .env existe
if (file_exists($dotenvPath . '.env')) {
    // Charger les variables d'environnement depuis le fichier .env
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();

  // Utiliser les variables d'environnement
  $webPage = $_ENV['WEB_URL'];
  $recaptchaPrivate = $_ENV['RECAPTCHA_PRIVATE'];
}
// Autoriser l'accès depuis des origines spécifiques 
header("Access-Control-Allow-Origin: $webPage" . 'authentification.php');
// Autoriser les en-têtes et méthodes spécifiques
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Vérifier la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Répondre immédiatement aux requêtes OPTIONS préalables
    http_response_code(200);
    exit();
}


// Vérifier si la méthode de la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure le fichier bdd.php pour établir une connexion à la base de données
    require_once 'bdd.php';
    // Récupérer la réponse reCAPTCHA du formulaire
    if (isset($_POST['g-recaptcha-response'])){
        $captchaResponse = $_POST['g-recaptcha-response'];
    } else {
        $_SESSION['response'] = "erreur de clé recaptcha";
        echo $_SESSION['response'];
        exit();
    }
    // Envoyer une requête POST pour vérifier la réponse reCAPTCHA
    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $recaptchaPrivate, // Votre clé privée reCAPTCHA
        'response' => $captchaResponse
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($verifyUrl, false, $context);
    $recaptchaResult = json_decode($response);

    // Vérifier si la réponse reCAPTCHA est valide
    if (!$recaptchaResult->success) {
        $_SESSION['response'] = "RECAPCTCHA DETECT BOT";
        echo $_SESSION['response'];
        exit();
    } 
        // Vérifier le jeton CSRF
    if (!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(403); // Forbidden
        $_SESSION['response'] = "Token CSRF invalide";
        echo $_SESSION['response'];
        exit();
    }
    // récupérer les données du formulaire //
    $firstname = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $lastname = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $mail = isset($_POST['mail']) ? $_POST['mail'] : null;
    $tel = isset($_POST['tel']) ? $_POST['tel'] : null;
    $allergies = isset($_POST['allergies']) ? $_POST['allergies'] : null;
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
    
   
    // Validation du format de l'email
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "L'adresse e-mail n'est pas valide.";
        echo $_SESSION['response'];
        exit();
    }
    // Vérifier si l'email existe déjà dans la base de données
    $queryEmailCheck = "SELECT * FROM users WHERE email = :email";
    $statementEmailCheck = $pdo->prepare($queryEmailCheck);
    $statementEmailCheck->bindParam(':email', $mail);
    $statementEmailCheck->execute();
    $existingUser = $statementEmailCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingUser) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "Cet email est déjà enregistré.";
        echo $_SESSION['response'];
        exit();
    }
    // Validation du format du prénom et du nom
    $regexName = '/^[A-Za-z]{3,}(?:-[A-Za-z]+)*$/'; // Au moins 3 lettres, "-" est le seul symbole accepté
    if (!preg_match($regexName, $firstname) || !preg_match($regexName, $lastname)) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "Le prénom et le nom doivent comporter au moins 3 lettres et peuvent contenir uniquement des lettres et des tirets.";
        echo $_SESSION['response'];
        exit();
    }
    // Validation du format du mot de passe
    $regexPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+-_])[A-Za-z\d@$!%*?&+-_]{8,}$/'; // Au moins 8 caractères avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial
    if (!preg_match($regexPassword, $new_password)) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "Le mot de passe doit contenir au moins 8 caractères avec au moins une majuscule, une minuscule, un chiffre et un caractère spécial.";
        echo $_SESSION['response'];
        exit();
    }
    // Vérification des mots de passe correspondants
    if ($new_password !== $confirm_password) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "Les mots de passe ne correspondent pas.";
        echo $_SESSION['response'];
        exit();
    }

    // Vérification du format du numéro de téléphone s'il est fourni
    if (!empty($tel)) {
        $tel = preg_replace('/\D/', '', $tel); // Suppression de tous les caractères non numériques
        if (strlen($tel) < 10) {
            http_response_code(400); // Bad Request
            $_SESSION['response'] = "Le numéro de téléphone doit comporter au moins 10 chiffres.";
            echo $_SESSION['response'];
            exit();
        }
    }
    // Validation des allergies s'il est fourni
    if (!empty($allergies)) {
        $regexAllergies = '/^[a-zA-Z\s]*$/'; // Seules les lettres et les espaces sont autorisés
        if (!preg_match($regexAllergies, $allergies)) {
            http_response_code(400); // Bad Request
            $_SESSION['response'] = "Les allergies ne doivent contenir que des lettres.";
            echo $_SESSION['response'];
            exit();
        }
    }
    //vérifications terminée inscritpion des données en base de données
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    // Insérer les données dans la table user
    $queryInsertUser = "INSERT INTO users (first_name, last_name, email, tel, allergies, password) VALUES (:first_name, :last_name, :email, :tel, :allergies, :password)";
    $statementInsertUser = $pdo->prepare($queryInsertUser);
    $statementInsertUser->bindParam(':first_name', $firstname);
    $statementInsertUser->bindParam(':last_name', $lastname);
    $statementInsertUser->bindParam(':email', $mail);
    $statementInsertUser->bindParam(':tel', $tel);
    $statementInsertUser->bindParam(':allergies', $allergies);
    $statementInsertUser->bindParam(':password', $hashed_password); // Stocker le mot de passe hashé
    $statementInsertUser->execute();

    // Définir le message de réponse dans la session
    $_SESSION['response'] = "Votre compte a bien été enregistré. Un mail de confirmation vous a été envoyé à $mail. Veuillez cliquer sur le lien s'y trouvant pour confirmer votre inscription. Merci et à bientôt ;)";
    echo  $_SESSION['response'];
        
        
    } else {
        // Méthode de requête non autorisée
        http_response_code(405);
        $_SESSION['response'] =  "Méthode non autorisée";
        exit();
    }
?>



