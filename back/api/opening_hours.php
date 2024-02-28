<?php

// En-têtes pour permettre l'accès depuis n'importe quel domaine
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");

// Connexion à la base de données
require_once __DIR__ . '\bdd.php';

try {
    // Récupérer les horaires d'ouverture pour les jours de la semaine
    $queryWeek = $pdo->query("SELECT * FROM open WHERE day = 'week'");
    $week = $queryWeek->fetch(PDO::FETCH_ASSOC);

    // Récupérer les horaires d'ouverture pour le samedi
    $querySaturday = $pdo->query("SELECT * FROM open WHERE day = 'saturday'");
    $saturday = $querySaturday->fetch(PDO::FETCH_ASSOC);

    // Récupérer les horaires d'ouverture pour le dimanche
    $querySunday = $pdo->query("SELECT * FROM open WHERE day = 'sunday'");
    $sunday = $querySunday->fetch(PDO::FETCH_ASSOC);

    // Envoyer les données sous forme JSON
    echo json_encode(compact('week', 'saturday', 'sunday'));
} catch (PDOException $e) {
    // En cas d'erreur de connexion à la base de données, afficher un message d'erreur
    echo json_encode(["error" => "Erreur lors de la récupération des horaires d'ouverture: " . $e->getMessage()]);
}

exit;

?>
