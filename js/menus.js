// récupération des div 
const drinks = document.getElementById('drinks');
const starters = document.getElementById('starters');
const dishes = document.getElementById('dishes');
const desserts = document.getElementById('desserts');

// Fonction pour afficher les images avec pagination
function showImagesWithPagination(imagesData, container) {
    const itemsPerPage = 1;
    let currentPage = 0;

    // Fonction pour afficher les images de la page actuelle
    function displayCurrentPage() {
        const startIndex = currentPage * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        container.innerHTML = ''; // Nettoyer le contenu actuel du conteneur

        // Boucler sur les images de la page actuelle et les ajouter au conteneur
        for (let i = startIndex; i < endIndex && i < imagesData.length; i++) {
            const img = document.createElement('img');
            img.src = imagesData[i];
            container.appendChild(img);
        }

        // Créer et ajouter des boutons de pagination
        const paginationContainer = document.createElement('div');
        paginationContainer.classList.add('pagination');

        const prevButton = document.createElement('button');
        prevButton.textContent = 'Précédent';
        prevButton.addEventListener('click', prevPage);
        paginationContainer.appendChild(prevButton);

        const nextButton = document.createElement('button');
        nextButton.textContent = 'Suivant';
        nextButton.addEventListener('click', nextPage);
        paginationContainer.appendChild(nextButton);

        // Ajouter le conteneur de pagination à la fin du conteneur de la catégorie
        container.appendChild(paginationContainer);
    }

    // Afficher la première page au chargement
    displayCurrentPage();

    // Fonction pour passer à la page suivante
    function nextPage() {
        currentPage++;
        if (currentPage >= Math.ceil(imagesData.length / itemsPerPage)) {
            currentPage = 0; // Revenir à la première page si on dépasse le nombre de pages
        }
        displayCurrentPage();
    }

    // Fonction pour passer à la page précédente
    function prevPage() {
        currentPage--;
        if (currentPage < 0) {
            currentPage = Math.ceil(imagesData.length / itemsPerPage) - 1; // Revenir à la dernière page si on dépasse la première page
        }
        displayCurrentPage();
    }
}

// Fonction asynchrone pour récupérer les données depuis l'API et traiter les images
async function fetchData() {
    try {
        const response = await fetch('../back/api/dishes.php');
        if (!response.ok) {
            throw new Error('problème de connexion api');
        }
        
        const data = await response.json();

        const startersData = data.starters.map(item => '../images/starters/' + item.picture);
        const dishesData = data.dishes.map(item => '../images/dishes/' + item.picture);
        const dessertsData = data.desserts.map(item => '../images/desserts/' + item.picture);

        // Afficher les images avec pagination pour chaque catégorie
        showImagesWithPagination(startersData, starters);
        showImagesWithPagination(dishesData, dishes);
        showImagesWithPagination(dessertsData, desserts);
    } catch (error) {
        console.error('erreur dans la requete', error);
    }
}

// Appeler la fonction pour récupérer les données depuis l'API
fetchData();
