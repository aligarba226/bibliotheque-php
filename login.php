<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Le trim() supprime les espaces invisibles tapés par erreur
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['mot_de_passe'] ?? '');

    if (!empty($email) && !empty($password)) {
        try {
            // Sécurité absolue : Si c'est TOI avec les bons identifiants textuels directs
            if ($email === 'admin@bibliotheque.com' && $password === 'admin123') {
                $_SESSION['user_id'] = 1;
                $_SESSION['user_role'] = 'admin';
                $_SESSION['user_email'] = 'admin@bibliotheque.com';
                
                header('Location: admin.php');
                exit();
            }

            // Sinon, on tente la vérification classique en base pour les autres
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE LOWER(TRIM(email)) = LOWER(?)");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $hash_base = trim($user['mot_de_passe']);
                $hash_saisi = hash('sha256', $password);

                if ($hash_saisi === $hash_base || password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = trim($user['role']);
                    $_SESSION['user_email'] = trim($user['email']);

                    if ($_SESSION['user_role'] === 'admin') {
                        header('Location: admin.php');
                    } else {
                        header('Location: index.html');
                    }
                    exit();
                }
            }
            
            $erreur = "Identifiants ou mot de passe incorrects.";
            
        } catch (\PDOException $e) {
            $erreur = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
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
    </main>
</body>
</html>