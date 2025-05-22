<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Supprime toutes les données de la session
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

// Facultatif : détruit complètement la session
session_destroy();

// Redirige vers la page d'accueil
header("Location: index.php");
exit;
?>