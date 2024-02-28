<?php 
//titre de page 
$pageTitle = 'Accueil';
//import de navBar et session_start() obligatoire pour ouverture html
require_once ('../components/navBar.php');
//importation du carousel
require_once ('../components/carousel.php');

?>
<!-- bouton de reservation -->
<div class="reservation_div">
        <div class="btn-reserv">
        <a href="/pages/reservation" class="nav-link">Réserver Une Table</a>
        </div>
</div>

<?php 
// import du footer !!!! obligatoire pour fermer le html
require_once ('../components/footer.php');

?>