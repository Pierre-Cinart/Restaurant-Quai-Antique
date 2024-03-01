<?php 
//titre de page 
$pageTitle = 'Gestion de profil';
//import de navBar et session_start() obligatoire pour ouverture html
require_once ('../components/navBar.php');
// <!-- tester si l utilisateur est connecté si non renvoyer vers la page de connexion -->

// <!-- si connecté recupérer les informations et préremplir le formulaires -->
$first_name = 'info client ';
$allergies = 'info client ';
$mail = 'client@mail.com';
$guests = 'info client ';
?>
<div class="profil-message">
    Bonjour <?= $first_name ?> 
</div>
<div class="my-form">
        <!-- Formulaire de connexion -->
    <form action="../back/api/updateProfil.php" method="POST">
        <h2>Modification des informations personnelles </h2>
        <br>
        <label for="mail">Modifier votre adresse mail </label>
        <input type="email" id="mail" name="mail" placeholder= "<?= $mail ?>">
        <label for="allergies">Modifier la mention des allergies :</label>
        <input type="text" id="allergies" name="allergies" placeholder="<?= $allergies ?>">
        <label for="guests">Modifier le nombre de couverts par défaut :</label>
        <input type="text" id="guests" name="guests" : placeholder= "<?= $mail ?>" >
        <button type="submit">Valider les changements</button>
    </form>
    <div class="sep"></div>
    <button>Modifier le mot de passe</button>

</div>

<?php 
// import du footer !!!! obligatoire pour fermer le html
require_once ('../components/footer.php');

?>