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
    
// Récupérer les données envoyées par la requête POST
    $selectedImageId = $_POST['selectedImageId'];
    $replaceImageId = $_POST['replaceImageId'];
    // Vérifier si les données nécessaires sont présentes
    if (!empty($selectedImageId) && !empty($replaceImageId)) {
        // Inclure le fichier de configuration de la base de données
        require_once 'bdd.php';

        // Préparer et exécuter la requête pour mettre à jour le champ dish_id de la table home_pictures
        $sql = "UPDATE home_pictures SET dish_id = :replaceImageId WHERE id = :selectedImageId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':replaceImageId', $replaceImageId, PDO::PARAM_INT);
        $stmt->bindParam(':selectedImageId', $selectedImageId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Envoyer une réponse JSON en cas de succès
            echo json_encode(array("success" => true));
        } else {
            // Envoyer une réponse JSON en cas d'échec
            http_response_code(500);
            echo json_encode(array("message" => "Échec de la mise à jour de l'image d'accueil."));
        }
    } else {
        // Envoyer une réponse JSON si les données nécessaires ne sont pas présentes
        http_response_code(400);
        echo json_encode(array("message" => "Données manquantes."));
    }

} else {
    // Méthode de requête non autorisée
    http_response_code(405);
    echo json_encode(["error" => "Méthode non autorisée"]);
    exit();
}
?>