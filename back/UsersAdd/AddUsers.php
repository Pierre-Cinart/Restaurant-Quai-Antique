<?php
// Inclure le fichier de configuration de la base de données
require_once '../api/bdd.php';

// Fonction de hachage du mot de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Ajouter le super admin
$sql = "INSERT INTO users (email, password, role, first_name, last_name) VALUES (:email, :password, :role, :first_name, :last_name)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'email' => 'arnaud@example.com',
    'password' => hashPassword('Mdp123'),
    'role' => 'super admin',
    'first_name' => 'Arnaud',
    'last_name' => 'Michant'
]);

// Ajouter l'admin
$stmt->execute([
    'email' => 'john@example.com',
    'password' => hashPassword('Mdp123'),
    'role' => 'admin',
    'first_name' => 'John',
    'last_name' => 'Doe'
]);

// Ajouter le client
$stmt->execute([
    'email' => 'robert@example.com',
    'password' => hashPassword('Mdp123'),
    'role' => 'client',
    'first_name' => 'Robert',
    'last_name' => 'Stallone'
]);

echo "Utilisateurs ajoutés avec succès !";
?>
