<?php 
//titre de page 
$pageTitle = 'Carte-Menus';
//import de navBar et session_start() obligatoire pour ouverture html
require_once ('../components/navBar.php');


?>

<section class="carte-menu">
      <div class="sort-titles">
        <h3 onclick="filterMenu('all')">Tout</h3>
        <h3 onclick="filterMenu('starters')">Entrées</h3>
        <h3 onclick="filterMenu('dishes')">Plats</h3>
        <h3 onclick="filterMenu('desserts')">Desserts</h3>
        <h3 onclick="filterMenu('drinks')">Boissons</h3>
      </div>

      <div class="sort-menus">
        <div id = "drinks">
          <img src='../images/drinks/drinks.jpg' >
        </div>
        <div id="starters">
            <p>starters</p>
        </div>
        <div id="dishes">
            <p>dishes</p>
        </div>
        <div id="desserts">
            <p>desserts</p>
        </div>
      </div>
    </section>




<?php 
// import du footer !!!! obligatoire pour fermer le html
require_once ('../components/footer.php');

?>
<script src="../js/menus.js"></script>
</body>
</html>