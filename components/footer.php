<footer class="bg-dark text-light py-4">
    <div class="footer_box">
        <div class="container contact">
            <ul>
                <h4>Contact :</h4>
                <li>
                    Restaurant quai antique <br>
                    15 rue des délices <br>
                    77555 Chamberry <br>
                </li>
                <li>tel : 040404040404 </li>
                <li>mail : quaiantique@mail.com </li>
            </ul>
        </div>

        <div class="reserv">
            <a href="/carte-menus" class="nav-link">Consulter La Carte</a>
            <a href="/reservation" class="nav-link">Réserver Une Table</a>
            <a href="/authentification" class="nav-link">Créer un compte client</a>
        </div>
         <!-- horraires -->
         <?php require_once ('openingHours.php') ?>
    </div>
    <div class="container text-center">
       <span>&copy; Cinartdev.fr</span>
    </div>
</footer>
<!-- cdn bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<!-- toggle navBar (mobile) -->
<script>
    function toggleNavbar() {
        const navbar = document.getElementById('navbarSupportedContent');
        navbar.classList.toggle('show');
    }

    // redirection logout
    function logout() {
        // Redirection vers la page de déconnexion
        window.location.href = 'logout.php';
    }
</script>
<!-- script pour affichage des popup -->
<script src="../js/popUp.js"></script>
<!-- vérification recaptcha  -->
<?php 
    if ($pageTitle == 'Authentification') {
        echo   "<script>
            function onClick(e) {
                e.preventDefault();
                grecaptcha.enterprise.ready(async () => {
                    const token = await grecaptcha.enterprise.execute('$recaptchaPublic', {action: 'LOGIN'});
                });
            }
        </script>";
    }
?>

