const popUp = document.getElementById('popUp');
show = 0;
function affPopUp () {
    if (show === 0 && popUp.classList.contains('none')) {
        popUp.classList.remove("none");
    }
    if (show < 9 ) {
        show ++ ;
        setTimeout(() => {
            affPopUp()
        },1000);
    }
    if (show === 9){
        popUp.classList.add("none");
    }
}
affPopUp();