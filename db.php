<?php
$host = 'bibliotheque-project-bibliotheque-project.b.aivencloud.com'; // Ton host Aiven
$port = '22347';                      // Ton port Aiven
$db   = 'defaultdb';                  
$user = 'avnadmin';                   

// Cette ligne va chercher le mot de passe de manière sécurisée sans l'afficher
$pass = getenv('DB_PASSWORD'); 

$charset = 'utf8mb4';
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

try {
     $pdo = new PDO($dsn, $user, $pass);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
     die("Erreur de connexion : " . $e->getMessage());
}
?>