<?php
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

// Chemin du fichier .env
$dotenvPath = __DIR__ . '/../../';

// Vérifier si le fichier .env existe
if (file_exists($dotenvPath . '.env')) {
    // Charger les variables d'environnement depuis le fichier .env
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();

  // Utiliser les variables d'environnement
  $host = $_ENV['DB_HOST'];
  $port = $_ENV['DB_PORT'];
  $database = $_ENV['DB_DATABASE'];
  $username = $_ENV['DB_USERNAME'];
  $password = $_ENV['DB_PASSWORD'];
}
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host={$host};port={$port};dbname={$database}", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // Gérer l'erreur de connexion
        die("Erreur de connexion à la base de données: " . $e->getMessage());
    }
// } else {
//     // Afficher un message d'erreur si le fichier .env n'est pas trouvé
//     die("Le fichier .env n'a pas été trouvé. Assurez-vous qu'il existe à l'emplacement spécifié.");
// }
