<?php
session_start();

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
    <title><?php echo $pageTitle;?></title>
    <title>Document</title>
</head>
<body>

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
              <a href="pages/reservation.php" class="nav-link" style="font-weight: bolder;">Réserver Une Table</a>
            </li>
            <?php if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
              <!-- Si l'utilisateur est connecté, affiche un bouton pour se déconnecter -->
              <li class="nav-item">
                <a href="pages/logout.php" class="nav-link" onclick="logout()">Se déconnecter</a>
              </li>
              <!-- Lien vers la page de profil -->
              <li class="nav-item">
                <a href="pages/profil.php" class="nav-link profile-link"><i class="fas fa-user"></i></a>
              </li>
              <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                <!-- Si l'utilisateur est administrateur, affiche le lien vers le tableau de bord -->
                <li class="nav-item">
                  <a href="pages/dashboard.php" class="nav-link profile-link">Dashboard</a>
                </li>
              <?php endif; ?>
            <?php else: ?>
              <!-- Si l'utilisateur n'est pas connecté, affiche le lien vers la page de connexion -->
              <li class="nav-item">
                <a href="pages/authentification.php" class="nav-link">Se connecter</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>


<!-- cdn bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- fonctions -->
<script>
function toggleNavbar() {
  const navbar = document.getElementById('navbarSupportedContent');
  navbar.classList.toggle('show');
}


function logout() {
  // Redirection vers la page de déconnexion
  window.location.href = 'logout.php';
}
</script>


</body>
</html>
