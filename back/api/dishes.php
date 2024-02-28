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

// Inclure le fichier de configuration de la base de données
require_once 'bdd.php';

// Requête SQL pour récupérer les données des plats
$sqlStarters = "SELECT title, description, price, picture FROM dishes WHERE category_id = 1";
$sqlDishes = "SELECT title, description, price, picture FROM dishes WHERE category_id = 2";
$sqlDesserts = "SELECT title, description, price, picture FROM dishes WHERE category_id = 3";

// Exécuter les requêtes
$stmtStarters = $pdo->query($sqlStarters);
$stmtDishes = $pdo->query($sqlDishes);
$stmtDesserts = $pdo->query($sqlDesserts);

// Vérifier s'il y a des résultats
if ($stmtStarters && $stmtDishes && $stmtDesserts) {
    // Récupérer les résultats sous forme de tableau associatif
    $starters = $stmtStarters->fetchAll(PDO::FETCH_ASSOC);
    $dishes = $stmtDishes->fetchAll(PDO::FETCH_ASSOC);
    $desserts = $stmtDesserts->fetchAll(PDO::FETCH_ASSOC);

    // Créer un tableau associatif pour renvoyer les données
    $responseData = array(
        "starters" => $starters,
        "dishes" => $dishes,
        "desserts" => $desserts
    );

    // Envoyer la réponse JSON
    echo json_encode($responseData);
} else {
    // En cas d'erreur, renvoyer un message d'erreur JSON
    http_response_code(500);
    echo json_encode(array("message" => "Impossible de récupérer les données des plats."));
}
?>
