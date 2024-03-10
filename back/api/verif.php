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

}
// Autoriser l'accès depuis des origines spécifiques 
header("Access-Control-Allow-Origin: *");
// Autoriser les en-têtes et méthodes spécifiques
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, OPTIONS");

// Vérifier la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Répondre immédiatement aux requêtes OPTIONS préalables
    http_response_code(200);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $code = isset($_GET['code']) ? $_GET['code'] : null;
   // import de bdd
    require_once 'bdd.php';
    //initialisation de la réponse
    $response = "";
    //  sélectionner l'utilisateur correspondant au code donné
    $query = "SELECT * FROM users WHERE jwt = :jwt";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':jwt', $code);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le champ updated_at est inférieur à 2 heures de différence
    if ($user) {
        $updatedAt = strtotime($user['updated_at']);
        $currentTime = time();
        if (($currentTime - $updatedAt) < 7200) { // 2 heures en secondes
            //mise jour de la table users 
            $updateQuery = "UPDATE users SET confirm = 'y', updated_at = NOW() WHERE jwt = :jwt";
            $updateStatement = $pdo->prepare($updateQuery);
            $updateStatement->bindParam(':jwt', $code);
            $updateStatement->execute();
            
            // La mise à jour a été effectuée avec succès
            $response  = "La confirmation du compte a été effectuée avec succès.";
            echo $response;
        } else {
            // Le délai pour la confirmation du compte a expiré
            $response  = "Le délai pour la confirmation du compte a expiré.";
            echo $response;
        }
    } else {
        // Aucun utilisateur trouvé avec le code donné
        $response  = "Code invalide.";
        echo $response;
    }
        exit();
}