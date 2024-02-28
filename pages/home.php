<?php 
//titre de page 
$pageTitle = 'Accueil';
//import de navBar et session_start();
require_once ('../components/navBar.php');
// Charger les variables d'environnement à partir du fichier .env
require_once __DIR__ . '/../vendor/autoload.php';
$dotenvPath = __DIR__ . '/../';
if (file_exists($dotenvPath . '.env')) {
    // Charger les variables d'environnement depuis le fichier .env
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();

  // Utiliser les variables d'environnement
  $apiUrl = $_ENV['API_URL'];
}



// Utiliser l'URL de l'API dans votre application PHP
echo "L'URL de l'API est : " . $apiUrl;
?>