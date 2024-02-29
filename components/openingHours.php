<?php
// Fonction pour formater le temps en HH:MM
function formatTime($time) {
    if ($time === null || $time === '') return ''; // Gérer le cas où le temps est null ou vide

    $formattedTime = strval($time);
    if (strlen($formattedTime) < 4) {
        // Ajouter des zéros avant si le nombre comporte moins de 4 chiffres
        $formattedTime = str_pad($formattedTime, 4, '0', STR_PAD_LEFT);
    }
    $hour = substr($formattedTime, 0, 2); // Prendre les deux premiers chiffres pour les heures
    $minute = substr($formattedTime, 2); // Prendre les deux derniers chiffres pour les minutes
    return $hour . ':' . $minute;
}

// Récupérer les données d'ouverture des heures depuis l'API
$apiEndPoint = $apiUrl . '/openingHours.php';
$response = file_get_contents($apiEndPoint);
$data = json_decode($response, true);

// Extraire les données de la réponse
$week = $data['week'];
$saturday = $data['saturday'];
$sunday = $data['sunday'];
?>

<div class="horraires">
    <h4>Nos heures d'ouverture :</h4>
    <ul>
        <?php if ($week): ?>
            <li>
                <span class="day"> Du Lundi au Vendredi :</span>
                <span>
                    de <?= formatTime($week['morning_start']) ?> à <?= formatTime($week['morning_end']) ?> <br>
                    et de <?= formatTime($week['after_start']) ?> à <?= formatTime($week['after_end']) ?>
                </span>
            </li>
        <?php endif; ?>
        <?php if ($saturday): ?>
            <li>
                <span class="day">Le Samedi : </span>
                <span>
                    de <?= formatTime($saturday['morning_start']) ?> à <?= formatTime($saturday['morning_end']) ?> <br>
                    et de <?= formatTime($saturday['after_start']) ?> à <?= formatTime($saturday['after_end']) ?>
                </span>
            </li>
        <?php endif; ?>
        <?php if ($sunday): ?>
            <li>
                <span class="day">Le Dimanche et jours fériés: </span>
                <span>
                    de <?= formatTime($sunday['morning_start']) ?> à <?= formatTime($sunday['morning_end']) ?> 
                </span>
            </li>
        <?php endif; ?>
    </ul>
</div>




