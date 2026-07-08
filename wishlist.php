<?php
require 'db.php';
$id_lecteur = 1; // On simule toujours le lecteur Jean Dupont (ID 1)

// Gestion de la suppression d'un livre de la liste (Action du CRUD)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id_livre'])) {
    $id_livre = (int)$_GET['id_livre'];
    $delete = $pdo->prepare("DELETE FROM liste_lecture WHERE id_livre = ? AND id_lecteur = ?");
    $delete->execute([$id_livre, $id_lecteur]);
    header("Location: wishlist.php"); // Recharge la page proprement
    exit;
}

// Récupération de la liste avec une jointure SQL
$query = "SELECT L.id, L.titre, L.auteur, Li.date_emprunt FROM liste_lecture Li JOIN Livres L ON Li.id_livre = L.id WHERE Li.id_lecteur = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_lecteur]);

// fetchAll() est laissé vide pour supprimer l'erreur de constante
$liste = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Liste de Lecture</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Ma Liste de Lecture</h2>
        <a href="index.html" class="btn">← Retour à l'accueil</a>
        <br><br>
        
        <?php if (!empty($liste)): ?>
            <ul>
                <?php foreach ($liste as $item): ?>
                    <li>
                        <span>
                            <strong><?php echo htmlspecialchars($item['titre']); ?></strong> - <?php echo htmlspecialchars($item['auteur']); ?>
                        </span>
                        <a href="wishlist.php?action=delete&id_livre=<?php echo $item['id']; ?>" class="delete-link" onclick="return confirm('Voulez-vous vraiment retirer ce livre de votre liste ?')">Retirer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Votre liste de lecture est actuellement vide.</p>
        <?php endif; ?>
    </main>
</body>
</html>