<?php 
require_once 'bdd.php';
$ip_address = getUserIPAddress();
$max_attempts = 5;



// Vérifier si le nombre de tentatives est dépassé
if (countFailedLoginAttempts() >= $max_attempts) {
   
}

// Fonction pour récupérer l'adresse IP
function getUserIPAddress()
{
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    // IP derrière un proxy
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Sinon : IP normale
    else {
        return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
}

// Fonction pour ajouter une tentative de connexion échouée à la table
function addFailedLoginAttempt() {
    global $pdo, $ip_address; 

    // Préparation de la requête SQL d'insertion
    $sql = "INSERT INTO failed_login_attempts (ip_address) VALUES (:ip_address)";

    // Préparation de la déclaration SQL
    $stmt = $pdo->prepare($sql);

    // Liaison des paramètres et exécution de la requête
    $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
    $stmt->execute();

    // Fermeture de la déclaration
    $stmt->closeCursor();
}

// Fonction pour vérifier le nombre de tentatives de connexion échouées pour une adresse IP donnée
function countFailedLoginAttempts() {
    global $pdo, $ip_address; 

    // Préparation de la requête SQL de comptage
    $sql = "SELECT COUNT(*) AS count FROM failed_login_attempts WHERE ip_address = :ip_address";

    // Préparation de la déclaration SQL
    $stmt = $pdo->prepare($sql);

    // Liaison des paramètres et exécution de la requête
    $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
    $stmt->execute();

    // Récupération du résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fermeture de la déclaration
    $stmt->closeCursor();

    // Retourne le nombre de tentatives de connexion échouées
    return $result['count'];
}
?>
