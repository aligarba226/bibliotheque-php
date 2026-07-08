<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On vide toutes les variables de session
$_SESSION = array();

// On détruit la session
session_destroy();

// Redirection vers l'accueil public
header("Location: index.html");
exit;
?>