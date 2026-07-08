<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si la session n'existe pas ou que le rôle n'est pas 'admin', on renvoie vers l'accueil public
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.html');
    exit;
}
?>