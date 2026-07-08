<?php
require 'db.php';

// Vérification de l'ID du livre à modifier
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
$stmt->execute([$id]);
$livre = $stmt->fetch();

if (!$livre) {
    die("livre introuvable.");
}

// Traitement de la mise à jour (Action UPDATE du CRUD)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_livre'])) {
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $description = trim($_POST['description']);
    $maison_edition = trim($_POST['maison_edition']);
    $nombre_exemplaire = (int)$_POST['nombre_exemplaire'];

    if (!empty($titre) && !empty($auteur)) {
        $update = $pdo->prepare("UPDATE livres SET titre = ?, auteur = ?, description = ?, maison_edition = ?, nombre_exemplaire = ? WHERE id = ?");
        $update->execute([$titre, $auteur, $description, $maison_edition, $nombre_exemplaire, $id]);
        
        // Redirection vers l'administration avec un message de succès
        echo "<script>alert('Le livre a été modifié avec succès !'); window.location.href='admin.php';</script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le livre - Administration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Modifier l'ouvrage : <?php echo htmlspecialchars($livre['titre']); ?></h2>
        <a href="admin.php" class="btn" style="background-color: #718096;">Annuler et retourner</a>
        <br><br>

        <form method="POST">
            <p>
                <label>Titre :</label><br>
                <input type="text" name="titre" value="<?php echo htmlspecialchars($livre['titre']); ?>" required>
            </p>
            <p>
                <label>Auteur :</label><br>
                <input type="text" name="auteur" value="<?php echo htmlspecialchars($livre['auteur']); ?>" required>
            </p>
            <p>
                <label>Maison d'édition :</label><br>
                <input type="text" name="maison_edition" value="<?php echo htmlspecialchars($livre['maison_edition']); ?>">
            </p>
            <p>
                <label>Nombre d'exemplaires :</label><br>
                <input type="number" name="nombre_exemplaire" value="<?php echo $livre['nombre_exemplaire']; ?>" min="0">
            </p>
            <p>
                <label>Description :</label><br>
                <textarea name="description" rows="4"><?php echo htmlspecialchars($livre['description']); ?></textarea>
            </p>
            <button type="submit" name="modifier_livre" class="btn btn-admin">Enregistrer les modifications</button>
        </form>
    </main>
</body>
</html>