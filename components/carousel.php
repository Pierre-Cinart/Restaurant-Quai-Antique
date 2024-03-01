<?php

class ImageCarousel {
    // Méthode pour récupérer les images depuis l'API
    public function getImages() {
        global $apiUrl;// apiUrl est declaré dans le composant navBar * appellé au debut de chaque pages du site

        // Endpoint de l'API pour récupérer les images
        $apiEndpoint = $apiUrl . '/img_home.php';

        // Effectuer une requête GET à l'API
        $response = file_get_contents($apiEndpoint);

        // Convertir la réponse JSON en tableau associatif
        $images = json_decode($response, true);
    
        // Vérifier si la requête a réussi
        if ($images !== null) {
            return $images;
        } else {
            // En cas d'erreur, afficher un message d'erreur
            echo "Erreur lors de la récupération d'images";
            return [];
        }
    }
}

// Instancier la classe ImageCarousel
$imageCarousel = new ImageCarousel();

// Récupérer les images
$images = $imageCarousel->getImages();
?>

<div id="imageCarousel" class="carousel slide " data-bs-ride="carousel" data-bs-interval="3500">
    <div class="carousel-inner">
        <?php foreach ($images as $index => $image) : ?>
            <?php $activeClass = ($index === 0) ? 'active' : ''; ?>
            <div class="carousel-item <?= $activeClass ?>">
                <div class="carousel-item-content">
                    <img src="<?= "../" . $image['path'] ?>" alt="<?= $image['title'] ?>" class="d-block " />
                    <div class="carousel-item-overlay">
                        <h3><?= $image['title'] ?></h3>
                        <p><?= $image['price'] ?> €</p>
                        <a href="./reservation.php" class="btn-reserv">Réserver une table !</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
  
</div>
