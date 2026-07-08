<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php'; // On utilise ta connexion $pdo de db.php

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['mot_de_passe'] ?? '');

    if (!empty($email) && !empty($password)) {
        try {
            // On cherche l'utilisateur dans la base Aiven
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // On vérifie si l'utilisateur existe et si le mot de passe correspond
            if ($user && password_verify($password, $user['mot_de_passe'])) {
                
                // On enregistre ses informations dans la Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_email'] = $user['email'];

                // Si c'est un admin, direction l'espace d'administration !
                if ($user['role'] === 'admin') {
                    header('Location: admin.php');
                } else {
                    header('Location: index.html');
                }
                exit();
            } else {
                $erreur = "Identifiants ou mot de passe incorrects.";
            }
        } catch (\PDOException $e) {
            $erreur = "Erreur lors de l'authentification : " . $e->getMessage();
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main style="max-width: 400px; margin: 50px auto; padding: 20px;">
        <h2>Connexion Espace Admin</h2>
        
        <?php if (!empty($erreur)): ?>
            <p style="color: #e53e3e; background: #fff5f5; padding: 10px; border-radius: 4px; border: 1px solid #fed7d7;">
                <?php echo htmlspecialchars($erreur); ?>
            </p>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <p>
                <label>Adresse Email :</label><br>
                <input type="email" name="email" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </p>
            <p>
                <label>Mot de passe :</label><br>
                <input type="password" name="mot_de_passe" required style="width: 100%; padding: 8px; margin-top: 5px;">
            </p>
            <br>
            <button type="submit" class="btn btn-admin" style="width: 100%;">Se connecter</button>
        </form>
        <br>
        <a href="index.html" style="text-align: center; display: block; color: #718096;">Retour au site public</a>
    </main>
</body>
</html>