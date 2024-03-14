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
        <div id="starters"></div>
        <div id="dishes"></div>
        <div id="desserts"></div>
      </div>
    </section>
  </div>
</template>

<!-- <script>
import TitleBox from '@/components/TitleBox.vue';
import axios from 'axios';

export default {
  components: {
    TitleBox,
  },
  data() {
    return {
      selectedMenu: 'all',
      showAll: true,
      starters: [],
      dishes: [],
      desserts: [],
      currentPageStarters: 0,
      currentPageDishes: 0,
      currentPageDesserts: 0,
      itemsPerPage: 2,
      isSmallScreen: false // Ajout d'une propriété pour vérifier la taille de l'écran
    };
  },
  computed: {
    paginatedStarters() {
      const startIndex = this.currentPageStarters * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.starters.slice(startIndex, endIndex);
    },
    paginatedDishes() {
      const startIndex = this.currentPageDishes * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.dishes.slice(startIndex, endIndex);
    },
    paginatedDesserts() {
      const startIndex = this.currentPageDesserts * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.desserts.slice(startIndex, endIndex);
    },
    totalPagesStarters() {
      return Math.ceil(this.starters.length / this.itemsPerPage);
    },
    totalPagesDishes() {
      return Math.ceil(this.dishes.length / this.itemsPerPage);
    },
    totalPagesDesserts() {
      return Math.ceil(this.desserts.length / this.itemsPerPage);
    }
  },
  mounted() {
    this.fetchStarters();
    this.fetchDishes();
    this.fetchDesserts();

    // Ajout d'un écouteur pour vérifier la taille de l'écran lors du montage du composant
    window.addEventListener('resize', this.checkScreenSize);
    this.checkScreenSize(); // Appel initial pour définir la taille de l'écran
  },
  unmounted() {
    // Suppression de l'écouteur lors de la destruction du composant pour éviter les fuites de mémoire
    window.removeEventListener('resize', this.checkScreenSize);
  },
  methods: {
    fetchStarters() {
      const apiEndpoint = `${process.env.VUE_APP_API_URL}/dishes.php`;
      axios.get(apiEndpoint)
        .then(response => {
          this.starters = response.data.starters;
        })
        .catch(error => {
          console.error("Erreur lors de la récupération des entrées:", error);
        });
    },
    fetchDishes() {
      const apiEndpoint = `${process.env.VUE_APP_API_URL}/dishes.php`;
      axios.get(apiEndpoint)
        .then(response => {
          this.dishes = response.data.dishes;
        })
        .catch(error => {
          console.error("Erreur lors de la récupération des plats:", error);
        });
    },
    fetchDesserts() {
      const apiEndpoint = `${process.env.VUE_APP_API_URL}/dishes.php`;
      axios.get(apiEndpoint)
        .then(response => {
          this.desserts = response.data.desserts;
        })
        .catch(error => {
          console.error("Erreur lors de la récupération des desserts:", error);
        });
    },
    filterMenu(menuType) {
      this.selectedMenu = menuType;
      if (menuType === 'all') {
        this.showAll = true;
      } else {
        this.showAll = false;
      }
    },
    nextPageStarters() {
      this.currentPageStarters++;
    },
    prevPageStarters() {
      this.currentPageStarters--;
    },
    nextPageDishes() {
      this.currentPageDishes++;
    },
    prevPageDishes() {
      this.currentPageDishes--;
    },
    nextPageDesserts() {
      this.currentPageDesserts++;
    },
    prevPageDesserts() {
      this.currentPageDesserts--;
    },
    toggleDescription(item) {
      // Vérifie si l'écran est inférieur à 800 pixels avant de permettre le toggle
      if (!this.isSmallScreen) {
        // Inverse le statut de l'affichage de la description de l'élément
        item.showDescription = !item.showDescription;
      }
    },
    showDescription(item) {
      // Affiche la description de l'élément
      item.showDescription = true;
    },
    hideDescription(item) {
      // Cache la description de l'élément
      item.showDescription = false;
    },
    checkScreenSize() {
      // Met à jour la propriété isSmallScreen en fonction de la taille de l'écran
      this.isSmallScreen = window.innerWidth <= 800;
    }
  }
};
</script> -->



<?php 
// import du footer !!!! obligatoire pour fermer le html
require_once ('../components/footer.php');

?>
<script src="../js/menus.js"></script>
</body>
</html>