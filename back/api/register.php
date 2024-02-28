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
    
    // Récupérer les données envoyées depuis le formulaire
    $data = json_decode(file_get_contents("php://input"));

    // Assigner les données à des variables locales
    $firstname = $data->firstName;
    $lastname = $data->lastName;
    $email = $data->email;
    $tel = $data->tel;
    $allergies = $data->allergies;
    $password = hashPassword($data->password); // Utilisation de la fonction hashPassword pour hacher le mot de passe
    $role = 'client'; // Définir le rôle par défaut à "client"

    // Insérer l'utilisateur dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO users (email, password, first_name, last_name, tel, allergies, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$email, $password, $firstname, $lastname, $tel, $allergies, $role]);

        // Répondre avec un code de succès et un message JSON
        http_response_code(201);
        echo json_encode(['message' => 'Inscription réussie.']);
    } catch (PDOException $e) {
        // En cas d'erreur de base de données, répondre avec un code d'erreur et un message JSON
        http_response_code(500);
        echo json_encode(['message' => 'Erreur de base de données: ' . $e->getMessage()]);
    }
} else {
    // Répondre avec un code d'erreur si la méthode n'est pas autorisée
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non autorisée.']);
}
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
?>
