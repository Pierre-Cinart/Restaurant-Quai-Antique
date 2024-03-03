<?php 
//titre de page 
$pageTitle = 'Authentification';
//import de navBar et session_start() obligatoire pour ouverture html
require_once ('../components/navBar.php');

// Génération du jeton CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

?>


<div class="my-form">
    <!-- Formulaire de connexion -->
<form action="../back/api/login.php" method="POST" id="loginForm">
    <h2>Connexion</h2>
    <!-- recaptcha -->
    
    <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>"> 
    <label for="email">E-mail :</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>
    <button class="g-recaptcha" 
        data-sitekey= "<?= $recaptchaPublic ?>"
        data-callback='onLoginSubmit' 
        data-action='submit'>Se connecter</button>
</form>

<div class="sep"></div>
<!-- Formulaire d'inscription -->
<form action="../back/api/register.php" method="POST" id ="registerForm">
    <h2>Inscription</h2>
    <!-- csrf token -->
    <input type="hidden" name="csrf_token" value="<?= $csrfToken; ?>"> 
    <label for="first_name">Prénom :</label>
    <input type="text" id="first_name" name="first_name" required>
    <label for="last_name">Nom  :</label>
    <input type="text" id="last_name" name="last_name" required>
    <label for="mail">mail :</label>
    <input type="email" id="mail" name="mail" required>
    <label for="new_password">Mot de passe :</label>
    <input type="password" id="new_password" name="new_password" required>
    <label for="confirm_password">Confirmer le mot de passe :</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <button class="g-recaptcha" 
        data-sitekey= "<?= $recaptchaPublic ?>"
        data-callback='onRegisterSubmit' 
        data-action='submit'>S'inscrire'</button>
</form>
</div>

<?php 
require_once ('../components/footer.php');
?>
 <script async src="https://www.google.com/recaptcha/api.js"></script>
 
 <script>
   function onLoginSubmit(token) {
     document.getElementById("loginForm").submit();
   }
   function onRegisterSubmit(token) {
    document.getElementById("registerForm").submit();
   }
 </script>
</body>
</html>