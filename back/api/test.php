<?php
$user_ip = '';

// Vérifier si l'adresse IP est transmise via un proxy
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    // Sinon, obtenir l'adresse IP directement
    $user_ip = $_SERVER['REMOTE_ADDR'];
}

// Vérifier si l'adresse IP est de la forme IPv6 locale "::1"
if (filter_var($user_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
    // L'adresse IP est IPv6 locale, donc on essaie d'obtenir l'adresse IP IPv4
    $user_ip = '';
}

// Si l'adresse IP n'a pas été récupérée ou est de la forme IPv6 locale "::1"
if (empty($user_ip)) {
    // Utiliser une méthode alternative pour obtenir l'adresse IP IPv4 locale
    $user_ip = $_SERVER['SERVER_ADDR'];
}

// Afficher l'adresse IP IPv4 de l'utilisateur
echo $user_ip;
