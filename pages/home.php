<?php 
        //titre de page 
        $pageTitle = 'Accueil';
        //import de navBar et session_start() obligatoire pour ouverture html
        require_once ('../components/navBar.php');
        
?>
<!-- titre entête -->
 <div class = "title-box">
        <h1>Bienvenue au restaurant Quai Antique</h1>
        <p>Découvrez les délices de la Savoie </p>
</div>

<!-- importation du carousel -->
<?php require_once ('../components/carousel.php'); ?>

<!-- bouton de reservation -->
<div class="reservation_div">
        <div class="btn-reserv">
        <a href="/pages/reservation.php" class="nav-link">Réserver Une Table</a>
        </div>
</div>

<?php 
// import du footer !!!! obligatoire pour fermer le html
require_once ('../components/footer.php');

?>
</body>
</html>