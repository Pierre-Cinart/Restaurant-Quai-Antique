<?php
// Vérifier si une session est active
if (!isset($_SESSION)) {
    // Activation du mode strict pour les variables de session
    ini_set('session.use_strict_mode', 1);
   
    // Limitation de validité à une heure
    session_set_cookie_params(3600);
}
//démarage de la session 
session_start();

// Charger la variables d'environnement pour le chemin vers les api à partir du fichier .env
require_once __DIR__ . '/../vendor/autoload.php';
$dotenvPath = __DIR__ . '/../';

if (file_exists($dotenvPath . '.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
  // Utiliser la variable d'environnement
  $apiUrl = $_ENV['API_URL'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cdn bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- fichier style -->
    <link rel="stylesheet" href="../css/style.css">
    <title><?= "Quai-antique - " . $pageTitle;?></title>
    <title>Document</title>
</head>
<body>
<?php var_dump($_SESSION);?>
  <header>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg bg-navBar">
      <div class="container-fluid">
        <!-- Logo à gauche -->
        <div>
          <a href="home.php" class="navbar-brand">
            <!-- Insérez votre logo ici -->
            <img src="../images/logo.png" alt="logo restaurant" class = "logo">
          </a>
        </div>

        <!-- Bouton de bascule à droite pour les petits écrans -->
        <button class="navbar-toggler" type="button" onclick="toggleNavbar()">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens de navigation à droite -->
        <div id="navbarSupportedContent" class="collapse navbar-collapse">

          <ul class="navbar-nav ms-auto">
            <!-- Lien vers la page d'accueil -->
            <li class="nav-item">
              <a href="home.php" class="nav-link active">Accueil</a>
            </li>
            <!-- Lien vers la page de consultation de la carte des menus -->
            <li class="nav-item">
              <a href="carte-menus.php" class="nav-link" style="font-weight: bolder;">Consulter La Carte</a>
            </li>
            <!-- Lien vers la page de réservation de table -->
            <li class="nav-item">
              <a href="reservation.php" class="nav-link" style="font-weight: bolder;">Réserver Une Table</a>
            </li>
            <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
              <!-- Si l'utilisateur est connecté, affiche un bouton pour se déconnecter -->
              <li class="nav-item">
                <a href="logout.php" class="nav-link" onclick="logout()">Se déconnecter</a>
              </li>
              <!-- Lien vers la page de profil -->
              <li class="nav-item">
                <a href="profil.php" class="nav-link profile-link"><i class="fas fa-user"></i></a>
              </li>
              <?php if(isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'super admin')): ?>
                <!-- Si l'utilisateur est administrateur, affiche le lien vers le tableau de bord -->
                <li class="nav-item">
                  <a href="../admin/dashboard.php" class="nav-link profile-link">Dashboard</a>
                </li>
              <?php endif; ?>
            <?php else: ?>
              <!-- Si l'utilisateur n'est pas connecté, affiche le lien vers la page de connexion -->
              <li class="nav-item">
                <a href="authentification.php" class="nav-link">Se connecter</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>




