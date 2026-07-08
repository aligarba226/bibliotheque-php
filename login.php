<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['mot_de_passe'] ?? '');

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $erreur = "DEBUG : Aucun utilisateur trouvé en base avec l'email : '" . htmlspecialchars($email) . "'";
            } else {
                // On vérifie la longueur du mot de passe stocké
                $longueur_hash = strlen($user['mot_de_passe']);
                
                if (password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_email'] = $user['email'];

                    if ($user['role'] === 'admin') {
                        header('Location: admin.php');
                    } else {
                        header('Location: index.html');
                    }
                    exit();
                } else {
                    $erreur = "DEBUG : Le mot de passe ne correspond pas. <br>" .
                              "Mot de passe tapé : " . htmlspecialchars($password) . "<br>" .
                              "Hash en base : " . htmlspecialchars($user['mot_de_passe']) . "<br>" .
                              "Longueur du hash en base : " . $longueur_hash . " caractères (il doit faire exactement 60 !)";
                }
            }
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
    <title>Diagnostic Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main style="max-width: 500px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px;">
        <h2>Connexion Espace Admin (Mode Diagnostic)</h2>
        
        <?php if (!empty($erreur)): ?>
            <div style="color: #b7791f; background: #fefcbf; padding: 15px; border-radius: 4px; border: 1px solid #fbd38d; font-family: monospace; font-size: 0.9rem; line-height: 1.5;">
                <?php echo $erreur; ?>
            </div>
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
            <button type="submit" class="btn btn-admin" style="width: 100%;">Tester la connexion</button>
        </form>
    </main>
</body>
</html>