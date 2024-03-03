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
// Autoriser l'accès depuis des origines spécifiques (ajustez selon vos besoins)
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

   // include_once 'login_attemps.php'; à développer
    
    // Initialiser la réponse
    $_SESSION['response'] = "";

    // Récupérer l'email et le mot de passe
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Vérifier si les données du formulaire sont présentes
    if (!$email || !$password) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "Veuillez fournir une adresse e-mail et un mot de passe";
        echo $_SESSION['response'];
        exit();
    }

        // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        $_SESSION['response'] = "L'adresse e-mail n'est pas valide";
        echo $_SESSION['response'];
        exit();
    }
    ///--------------- mettre un exit si le nombre de requête est supérieur à 5 ----- login-attempts

    // Requête pour récupérer l'utilisateur avec l'email
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe correspond
    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie
        // verification de la validation du compte : 
        if ($user['confirm'] == 'y'){
              //genere un code de 64 caractères
            $jwt = bin2hex(random_bytes(32)); 
            
            // Enregistrer le JWT dans la base de données pour cet utilisateur
            $queryUpdateJWT = "UPDATE users SET jwt = :jwt WHERE user_id = :user_id";
            $statementUpdateJWT = $pdo->prepare($queryUpdateJWT);
            $statementUpdateJWT->bindParam(':jwt', $jwt);
            $statementUpdateJWT->bindParam(':user_id', $user['user_id']);
            $statementUpdateJWT->execute();

            // Enregistrer les données en variable de session
        
            $_SESSION["id"] = $user['user_id'];
            $_SESSION["firstname"] = $user['first_name'];
            $_SESSION["lastname"] = $user['last_name'];
            $_SESSION["fullname"] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION["jwt"] = $jwt; // Ajouter le JWT à la réponse
            $_SESSION["isLoggedIn"] = true;
            $_SESSION["role"] = $user['role'];
            $_SESSION['response'] = "Compte connecté.";
      
        } else {
            $_SESSION['response'] = "Votre compte n ' a pas était validé . Veuillez consulter vos mails et cliquer sur le lien de confiramtion qui vous a était envoyé ";
            echo $_SESSION['response'];
            exit(); 
        }
        //------------- delete les tentatives ----- login-attempts
      
    } else {
        // Authentification échouée
        // ------------incrementer les tentatives ----- login-attempts
        // Vous pouvez gérer cela ici en fonction de votre implémentation
        http_response_code(401); // Unauthorized
        $_SESSION['response'] = "Identifiants incorrects";
        echo $_SESSION['response'];
    }

    // Redirection vers la page d accueil
    header("Location: ../../pages/home.php");
    exit;
    
} else {
    // Méthode de requête non autorisée
    http_response_code(405);
    $_SESSION['response'] =  "Méthode non autorisée";
    echo $_SESSION['response'];
    exit();
}
?>
