<?php
// Fonction pour formater le temps en HH:MM
function formatTime($time) {
    return substr_replace($time, ':', -2, 0);
}

// Fonction pour formater l'heure de réservation en HH:MM
function formatReservTime($time) {
    return substr($time, 0, 5); // Récupère les 5 premiers caractères (HH:MM)
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'bdd.php';

// Vérifier si la méthode de la requête est GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Vérifier si le paramètre 'date' est présent dans l'URL
    if(isset($_GET['date'])) {
        // Récupérer la date depuis les paramètres GET
        $date = $_GET['date'];
        
        // Convertir la date en format adapté pour la recherche dans la base de données
        $dayOfWeek = strtolower(date('l', strtotime($date)));

        // Préparer la requête SQL en fonction du jour de la semaine
        switch ($dayOfWeek) {
            case 'monday':
            case 'tuesday':
            case 'wednesday':
            case 'thursday':
            case 'friday':
                $dayOfWeek = 'week';
                break;
            case 'saturday':
                $dayOfWeek = 'saturday';
                break;
            case 'sunday':
                $dayOfWeek = 'sunday';
                break;
            default:
                // Si le jour de la semaine n'est pas valide, renvoyer une erreur
                http_response_code(400);
                echo json_encode(array("error" => "Jour de la semaine invalide"));
                exit();
        }

        // Requête SQL pour récupérer les horaires d'ouverture pour le jour sélectionné
        $query = "SELECT * FROM open WHERE day = :day";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':day', $dayOfWeek);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Vérifier si des horaires d'ouverture ont été trouvés
        if ($result) {
            // Convertir les horaires au format adapté pour l'affichage
            $openingHours = array(
                "morning_start" => formatTime($result['morning_start']),
                "morning_end" => formatTime($result['morning_end']),
                "after_start" => formatTime($result['after_start']),
                "after_end" => formatTime($result['after_end'])
            );

            // Créer un tableau des horaires avec les places disponibles par tranche de 15 minutes
            $timeSlots = array();
            $startTime = strtotime($result['morning_start']);
            $endTime = strtotime('-15 minutes', strtotime($result['morning_end']));
            while ($startTime <= $endTime) {
                $timeSlots[date('H:i', $startTime)] = 15;
                $startTime = strtotime('+15 minutes', $startTime);
            }

            // Ajouter les horaires de l'après-midi
            $startTime = strtotime($result['after_start']);
            $endTime = strtotime('-1 hour -15 minutes', strtotime($result['after_end']));
            while ($startTime <= $endTime) {
                $timeSlots[date('H:i', $startTime)] = 15;
                $startTime = strtotime('+15 minutes', $startTime);
            }

            // Requête SQL pour récupérer les réservations pour la date sélectionnée
            $queryReservations = "SELECT reservation_time, number_of_guests FROM reservations WHERE reservation_date = :date";
            $statementReservations = $pdo->prepare($queryReservations);
            $statementReservations->bindParam(':date', $date);
            $statementReservations->execute();
            $reservations = $statementReservations->fetchAll(PDO::FETCH_ASSOC);

            // Mettre à jour les places disponibles en fonction des réservations existantes
            foreach ($reservations as $reservation) {
                $reservationTime = formatReservTime($reservation['reservation_time']);
                if (array_key_exists($reservationTime, $timeSlots)) {
                    // Si la tranche horaire existe dans $timeSlots, réduire le nombre de places disponibles
                    // en soustrayant le nombre de personnes de la réservation
                    $timeSlots[$reservationTime] -= $reservation['number_of_guests'];
                    // Vérifier si le nombre de places disponibles est inférieur à zéro
                    // et le mettre à zéro pour éviter les valeurs négatives
                    if ($timeSlots[$reservationTime] < 0) {
                        $timeSlots[$reservationTime] = 0;
                    }
                }
            }

            // Envoyer les horaires disponibles avec les places restantes au format JSON
            http_response_code(200);
            echo json_encode($timeSlots);
        } else {
            // Si aucun horaire d'ouverture n'a été trouvé, renvoyer une erreur
            http_response_code(404);
            echo json_encode(array("error" => "Aucun horaire d'ouverture trouvé pour la date sélectionnée"));
        }
    } else {
        // Si le paramètre 'date' est manquant, renvoyer une erreur
        http_response_code(400);
        echo json_encode(array("error" => "Paramètre 'date' manquant"));
    }
} else {
    // Si la méthode de requête n'est pas GET, renvoyer une erreur
    http_response_code(405);
    echo json_encode(array("error" => "Méthode non autorisée"));
}
?>
