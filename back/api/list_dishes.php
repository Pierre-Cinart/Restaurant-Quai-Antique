<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");

// Inclure le fichier de configuration de la base de données
require_once 'bdd.php';

// Requête SQL pour récupérer les IDs et les URLs des images des plats de la catégorie spécifiée
$sql = "SELECT dish_id, picture, category_id FROM dishes where category_id !=4";

try {
    // Exécutez la requête
    $stmt = $pdo->query($sql);

    // Vérifiez s'il y a des résultats
    if ($stmt) {
        // Récupérez les données des plats
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Traiter les chemins d'accès en fonction de la catégorie
        $images = array_map(function($item) {
            $basePath = '/images/';
            $category = '';
            switch ($item['category_id']) {
                case 1:
                    $category = 'starters/';
                    break;
                case 2:
                    $category = 'dishes/';
                    break;
                case 3:
                    $category = 'desserts/';
                    break;
                default:
                    $category = 'unknown/';
            }
            $item['path'] = $basePath . $category . $item['picture'];
            return $item;
        }, $data);

        // Encodez les résultats en format JSON
        $json = json_encode($images);

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
