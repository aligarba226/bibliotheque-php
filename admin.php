<?php
require 'db.php';

// 1. GESTION DE L'AJOUT D'UN LIVRE (Action "Create" du CRUD)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_livre'])) {
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $description = trim($_POST['description']);
    $maison_edition = trim($_POST['maison_edition']);
    $nombre_exemplaire = (int)$_POST['nombre_exemplaire'];

    if (!empty($titre) && !empty($auteur)) {
        $insert = $pdo->prepare("INSERT INTO livres (titre, auteur, description, maison_edition, nombre_exemplaire) VALUES (?, ?, ?, ?, ?)");
        $insert->execute([$titre, $auteur, $description, $maison_edition, $nombre_exemplaire]);
        echo "<script>alert('Nouveau livre ajouté avec succès dans la collection !');</script>";
    }
}

// 2. GESTION DE LA SUPPRESSION D'UN LIVRE (Action "Delete" du CRUD)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id_livre'])) {
    $id_livre = (int)$_GET['id_livre'];
    $delete = $pdo->prepare("DELETE FROM livres WHERE id = ?");
    $delete->execute([$id_livre]);
    header("Location: admin.php");
    exit;
}

// 3. RÉCUPÉRATION DE TOUS LES LIVRES POUR LE TABLEAU (Action "Read" du CRUD)
$stmt = $pdo->query("SELECT * FROM livres ORDER BY id DESC");
// fetchAll() est laissé vide pour éviter les erreurs de constantes PDO
$tous_les_livres = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Gestion - Administration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Espace Administration de la Bibliothèque</h2>
        <a href="index.html" class="btn">Retour à l'accueil public</a>
        <br><br>

        <h3>Ajouter un nouveau livre à la collection</h3>
        <form method="POST">
            <p>
                <label>Titre :</label><br>
                <input type="text" name="titre" required>
            </p>
            <p>
                <label>Auteur :</label><br>
                <input type="text" name="auteur" required>
            </p>
            <p>
                <label>Maison d'édition :</label><br>
                <input type="text" name="maison_edition">
            </p>
            <p>
                <label>Nombre d'exemplaires :</label><br>
                <input type="number" name="nombre_exemplaire" value="1" min="0">
            </p>
            <p>
                <label>Description :</label><br>
                <textarea name="description" rows="4"></textarea>
            </p>
            <button type="submit" name="ajouter_livre" class="btn btn-admin">Insérer le livre</button>
        </form>

        <br><br>

        <h3>Liste complète des livres de la collection</h3>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Exemplaires</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tous_les_livres)): ?>
                    <?php foreach ($tous_les_livres as $l): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($l['titre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($l['auteur']); ?></td>
                            <td><?php echo $l['nombre_exemplaire']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $l['id']; ?>" class="btn" style="padding: 4px 10px; font-size: 0.85rem; background-color: var(--secondary-color); margin-right: 10px;">Modifier</a>
                                <a href="admin.php?action=delete&id_livre=<?php echo $l['id']; ?>" class="delete-link" onclick="return confirm('Supprimer définitivement ce livre de la bibliothèque ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun livre dans la collection.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>