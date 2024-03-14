//script pour la carte des menus
// récupération des div 
const drinks = document.getElementById('drinks');
const starters = document.getElementById('starters');
const dishes = document.getElementById('dishes');
const desserts = document.getElementById('desserts');

// fonction de tri sur les titres
function filterMenu(str_menu) { // string en param lancé sur le html cartes-menus.php
    console.log("menu selectionné : " + str_menu);
    switch (str_menu) {
        case 'all': {
            showMenu(drinks);
            showMenu(starters);
            showMenu(dishes);
            showMenu(desserts);
        }
        break;
        case 'drinks': {
            showMenu(drinks);
            maskMenu(starters);
            maskMenu(dishes);
            maskMenu(desserts);
        } 
        break;
        case 'starters': {
            showMenu(starters);
            maskMenu(drinks);
            maskMenu(dishes);
            maskMenu(desserts);
        } 
        break;
        case 'dishes': {
            showMenu(dishes);
            maskMenu(drinks);
            maskMenu(starters);
            maskMenu(desserts);
        } 
        break;
        case 'desserts': {
            showMenu(desserts);
            maskMenu(starters);
            maskMenu(drinks);
            maskMenu(dishes);
            
        } 
        break;
    }
    
}

// fonction  d affichage des menus
function showMenu(menu) {
    if (menu.classList.contains('none')){
        menu.classList.remove('none');
    } 
}

//fonction de masquage des menus 
function maskMenu (menu) {
    if (!menu.classList.contains('none')){
        menu.classList.add('none');
    } 
}
