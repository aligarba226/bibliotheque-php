<?php
$host = 'bibliotheque-project-bibliotheque-project.b.aivencloud.com/'; // Ton Host Aiven
$port = '22347';                      // Ton Port Aiven
$db   = 'defaultdb';                  // Ta base Aiven
$user = 'avnadmin';                   // Ton User Aiven
$pass = 'AVNS_ecQ4RNV5ALkevEm-8Et';     // Ton MDP Aiven
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $pass);
     echo "Connecté à Aiven avec succès !";
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>