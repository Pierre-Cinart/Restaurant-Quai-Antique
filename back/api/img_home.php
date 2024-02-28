<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");

// Inclure le fichier de configuration de la base de données
require_once 'bdd.php';

// Requête SQL pour récupérer les données de la table home_pictures avec une jointure sur la table dishes
$sql = "SELECT hp.id AS home_picture_id, d.picture AS picture_name, d.category_id, d.title, d.price
        FROM home_pictures hp
        INNER JOIN dishes d ON hp.dish_id = d.dish_id";

try {
    // Exécutez la requête
    $stmt = $pdo->query($sql);

    // Vérifiez s'il y a des résultats
    if ($stmt) {
        // Récupérez les données des images
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ajoutez le chemin de l'image en fonction de la catégorie
        foreach ($data as &$image) {
            switch ($image['category_id']) {
                case 1:
                    $image['path'] = '/images/starters/' . $image['picture_name'];
                    break;
                case 2:
                    $image['path'] = '/images/dishes/' . $image['picture_name'];
                    break;
                case 3:
                    $image['path'] = '/images/desserts/' . $image['picture_name'];
                    break;
                default:
                    $image['path'] = ''; // Par défaut, path est une chaîne vide
            }
            // Supprimez les colonnes non nécessaires
            unset($image['picture_name']);
            unset($image['category_id']);
        }

        // Encodez les résultats en format JSON
        $json = json_encode($data);

        // Envoyez la réponse JSON
        echo $json;
    } else {
        // En cas d'erreur, renvoyez un message d'erreur JSON
        http_response_code(500);
        echo json_encode(array("message" => "Impossible de récupérer les données."));
    }
} catch (PDOException $e) {
    // En cas d'erreur de connexion à la base de données, renvoyez un message d'erreur JSON
    http_response_code(500);
    echo json_encode(array("message" => "Erreur de connexion à la base de données: " . $e->getMessage()));
}
?>
