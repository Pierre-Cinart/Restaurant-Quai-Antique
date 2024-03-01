<?php
// Autoriser l'accès depuis n'importe quelle origine
header("Access-Control-Allow-Origin: *");

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
   // include_once 'login_attemps.php'; à développer
    
    // Initialiser la réponse
    $response = [];

    // Récupérer l'email et le mot de passe
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Vérifier si les données du formulaire sont présentes
    if (!$email || !$password) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Veuillez fournir une adresse e-mail et un mot de passe"]);
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
        //------------- delete les tentatives ----- login-attempts

        // Générer le JWT
        $jwt = bin2hex(random_bytes(32)); // Utilisez 32 octets pour obtenir 64 caractères hexadécimaux
        
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

        // Ajouter les données de l'utilisateur à la réponse
        $response = [
            "id" => $user['user_id'],
            "firstname" => $user['first_name'],
            "lastname" => $user['last_name'],
            "fullname" => $user['first_name'] . " " . $user['last_name'],
            "jwt" => $jwt
        ];
    } else {
        // Authentification échouée
        // ------------incrementer les tentatives ----- login-attempts
        // Vous pouvez gérer cela ici en fonction de votre implémentation
        http_response_code(401); // Unauthorized
        $response = ["error" => "Identifiants incorrects"];
    }

    // Envoyer la réponse au format JSON
    echo json_encode($response);
    
} else {
    // Méthode de requête non autorisée
    http_response_code(405);
    echo json_encode(["error" => "Méthode non autorisée"]);
    exit();
}
?>
