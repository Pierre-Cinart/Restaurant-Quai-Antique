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
    include_once 'login_attemps.php';
    // Récupérer les données envoyées depuis le formulaire
    $data = json_decode(file_get_contents("php://input"));

    // Récupérer l'email et le mot de passe
    $email = $data->email;
    $password = $data->password;

    ///--------------- mettre un exit si le nombre de requete est supérieur à 5 ----- login-attemps

    //  requête pour récupérer l'utilisateur avec l email
    $query = "SELECT * FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le mot de passe correspond
    if ($user && password_verify($password, $user['password'])) {
        // Authentification réussie
        //------------- delete les tentatives ----- login-attemps

        // Générer le JWT
        $jwt = bin2hex(random_bytes(32)); // Utilisez 32 octets pour obtenir 64 caractères hexadécimaux
       
        // Enregistrer le JWT dans la base de données pour cet utilisateur
        $queryUpdateJWT = "UPDATE users SET jwt = :jwt WHERE user_id = :user_id";
        $statementUpdateJWT = $pdo->prepare($queryUpdateJWT);
        $statementUpdateJWT->bindParam(':jwt', $jwt);
        $statementUpdateJWT->bindParam(':user_id', $user['user_id']);
        $statementUpdateJWT->execute();

        //camouflage des roles
        
        function assignRoleCode($role) {
            switch ($role) {
                case 'client':
                    return 321;
                case 'admin':
                    return 555;
                case 'super admin':
                    return 745;
                default:
                    return 0; // Code de rôle par défaut si le rôle n'est pas reconnu
            }
        }
        
        // Utilisation de la fonction pour attribuer le code de rôle
        $roleCode = assignRoleCode($user['role']);
        
        // Répondre avec les informations de l'utilisateur et le JWT
        $response = (object) [
            "id" => $user['user_id'],
            "role" => $roleCode, // Utilisation du code de rôle attribué
            "firstname" => $user['first_name'],
            "lastname" => $user['last_name'],
            "fullname" => $user['first_name'] . " " . $user['last_name'],
            "jwt" => $jwt // Ajouter le JWT à la réponse
        ];
    } else {
        // Authentification échouée
        // ------------incrementer les tentatives ----- login-attemps
        $response = null;
    }

    // Envoyer la réponse au format JSON
    // Enregistrer le JWT dans le localStorage
    
    echo json_encode($response);
    
} else {
    // Méthode de requête non autorisée
    http_response_code(405);
    echo json_encode(["error" => "Méthode non autorisée"]);
    exit();
}
?>
