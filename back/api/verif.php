<?php
//importation de php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//chemin de vendor autoload
require_once __DIR__ . '/../../vendor/autoload.php';

// Chemin du fichier .env
$dotenvPath = __DIR__ . '/../../';

// Vérifier si le fichier .env existe
if (file_exists($dotenvPath . '.env')) {
    // Charger les variables d'environnement depuis le fichier .env
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
    //utilisation de variable 
    $apiUrl = $_ENV['API_URL'];
}
// Autoriser l'accès depuis des origines spécifiques 
header("Access-Control-Allow-Origin: *");
// Autoriser les en-têtes et méthodes spécifiques
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, OPTIONS");

// Vérifier la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Répondre immédiatement aux requêtes OPTIONS préalables
    http_response_code(200);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $code = isset($_GET['code']) ? $_GET['code'] : null;
   // import de bdd
    require_once 'bdd.php';
    
    //  sélectionner l'utilisateur correspondant au code donné
    $query = "SELECT * FROM users WHERE jwt = :jwt";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':jwt', $code);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe et si le champ updated_at est inférieur à 2 heures de différence
    if ($user) {
        //recupération des données de l utilisateur
        $jwt = bin2hex(random_bytes(32));
        $email = $user['email'];
        $firstname = $user['first_name'];
        $lastname = $user['last_name'];
        $updatedAt = strtotime($user['updated_at']);
        $currentTime = time();
        if (($currentTime - $updatedAt) < 7200) { // 2 heures en secondes
            //mise jour de la table users 
            $updateQuery = "UPDATE users SET jwt =:jwt ,confirm = 'y', updated_at = NOW() WHERE email = :email";
            $updateStatement = $pdo->prepare($updateQuery);
            $updateStatement->bindParam(':jwt', $jwt);
            $updateStatement->bindParam(':email', $email);
            $updateStatement->execute();
            
            // La mise à jour a été effectuée avec succès
            $_SESSION['response']  = "La confirmation du compte a été effectuée avec succès.";
            $_SESSION['type'] = 'success';
        } else {
            // envoie d 'un nouveau lien de confirmation et mise à jours de users
            $updateQuery = "UPDATE users SET jwt = :jwt, updated_at = NOW() WHERE email = :email";
            $updateStatement = $pdo->prepare($updateQuery);
            $updateStatement->bindParam(':jwt', $jwt);
            $updateStatement->bindParam(':email', $email);
            $updateStatement->execute();

            //envoie d un nouveau lien de confirmation
            $mail = new PHPMailer(true);
            try {
                // Paramètres SMTP de Mailtrap
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->Port = $_ENV['SMTP_PORT'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USERNAME'];
                $mail->Password = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utilisez STARTTLS pour le chiffrement TLS
                $mail->CharSet = 'UTF-8'; // Définit l'encodage des caractères
                $mail->ContentType = 'text/html; charset=UTF-8'; // Spécifie le type de contenu et l'encodage
                // Destinataire et expéditeur
                $mail->setFrom('quai-antique@noreply.mail', 'Arnaud Michant');
                $mail->addAddress($email, $firstname . ' ' . $lastname);
        
                // Contenu de l'e-mail
                $mail->isHTML(true);
                $mail->Subject = 'confirmation de compte';
                $mail->Body = "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>Vous avez créé un compte sur notre site Quai antique. Veuillez cliquer sur le lien ci-dessous pour valider votre inscription : <a href='$apiUrl/verif.php?code=$jwt'>CONFIRMER LE COMPTE</a></body></html>";
                
        
                // Envoyer l'e-mail
                $mail->send();
           
            } catch (Exception $e) {
                $_SESSION['response']  = 'Échec de l\'envoi de l\'e-mail. Erreur : '.  $e->getMessage();
                $_SESSION['type'] = 'error';
                exit();
            }
            // Le délai pour la confirmation du compte a expiré
            $_SESSION['response']  = "Le délai pour la confirmation du compte a expiré.\n Un nouveau message de confirmation vous à était envoyé sur votre adresse mail \n veuillez suivre les instructions de celui ci pour confirmer votre inscription";
            $_SESSION['type'] = 'error';
        }
    } else {
        // Aucun utilisateur trouvé avec le code donné
        $_SESSION['response']  = "Code invalide.";
        $_SESSION['type'] = 'error';
    }
        exit();
}