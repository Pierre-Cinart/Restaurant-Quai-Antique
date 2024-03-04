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
    // récupérer les données du formulaire
    $firstname = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $lastname = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $mail = isset($_POST['mail']) ? $_POST['mail'] : null;
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
    $tel = isset($_POST['tel']) ? $_POST['tel'] : null;
    $allergies = isset($_POST['allergies']) ? $_POST['allergies'] : null;

    
} else {
    // Méthode de requête non autorisée
    http_response_code(405);
    $_SESSION['response'] =  "Méthode non autorisée";
    echo $_SESSION['response'];
    exit();
}
?>



