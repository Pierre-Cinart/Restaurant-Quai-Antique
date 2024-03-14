//script pour la carte des menus
// récupération des div 
const drinks = document.getElementById('drinks');
const starters = document.getElementById('starters');
const dishes = document.getElementById('dishes');
const desserts = document.getElementById('desserts');

// fonction de tri sur les titres
function filterMenu(menu) {
    console.log("menu selectionné : " + menu);
    if (menu == 'all') {
        showMenu('drinks');
        showMenu('starters');
        showMenu('dishes');
        showMenu('desserts');
    } else {
        showMenu(menu);
    }
}

// fonction  d affichage des menus
function showMenu(menu) {
    switch (menu) {
        case 'drinks': {
            if (drinks.classList.contains('none')){
                drinks.classList.remove('none');
            }
        } break;
        case 'starters': {
                if (starters.classList.contains('none')){
                    starters.classList.remove('none');
                } 
        } break;
        case 'dishes': {
            if (dishes.classList.contains('none')){
                dishes.classList.remove('none');
            } 
        } break;
        case 'desserts': {
            if (desserts.classList.contains('none')){
                desserts.classList.remove('none');
            } 
        } break;
    }
}
