<?php 
//titre de page 
$pageTitle = 'Authentification';
//import de navBar et session_start() obligatoire pour ouverture html
require_once ('../components/navBar.php');


?>

<div class="my-form">
    <!-- Formulaire de connexion -->
<form action="../back/api/login.php" method="POST">
    <h2>Connexion</h2>
    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Se connecter</button>
</form>
<div class="sep"></div>
<!-- Formulaire d'inscription -->
<form action="../back/api/register.php" method="POST">
    <h2>Inscription</h2>
    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" required>
    <label for="last_name">Nom  :</label>
    <input type="text" id="last_name" name="last_name" required>
    <label for="mail">mail :</label>
    <input type="email" id="mail" name="mail" required>
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>
    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <button type="submit">S'inscrire</button>
</form>
</div>

<?php 

// import du footer !!!! obligatoire pour fermer le html
require_once ('../components/footer.php');

?>