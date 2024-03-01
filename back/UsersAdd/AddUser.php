<?php
// Inclure le fichier de configuration de la base de données
require_once '../api/bdd.php';

// Fonction de hachage du mot de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Ajouter le super admin
$sql = "INSERT INTO users (email, password, role, first_name, last_name,confirm) VALUES (:email, :password, :role, :first_name, :last_name,:confirm)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'email' => 'arnaud@example.com',
    'password' => hashPassword('Mdp123'),
    'role' => 'super admin',
    'first_name' => 'Arnaud',
    'last_name' => 'Michant',
    'confirm' => 'y'
]);

// Réinitialiser les valeurs des paramètres de liaison pour l'admin
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':first_name', $first_name);
$stmt->bindParam(':last_name', $last_name);
$stmt->bindParam(':confirm', $confirm);

// Ajouter l'admin
$email = 'john@example.com';
$password = hashPassword('Mdp123');
$role = 'admin';
$first_name = 'John';
$last_name = 'Doe';
$confirm = 'y';
$stmt->execute();

// Réinitialiser les valeurs des paramètres de liaison pour le client
$email = 'robert@example.com';
$password = hashPassword('Mdp123');
$role = 'client';
$first_name = 'Robert';
$last_name = 'Stallone';
$confirm = 'y';
$stmt->execute();

echo "Utilisateurs ajoutés avec succès !";
?>
