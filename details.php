<?php
require 'db.php';

// Récupération de l'ID du livre depuis l'URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Préparation et exécution de la requête pour récupérer le livre sélectionné
$stmt = $pdo->prepare("SELECT * FROM Livres WHERE id = ?");
$stmt->execute([$id]);

// fetch() est laissé vide pour éviter l'erreur de constante
$livre = $stmt->fetch();

// Si aucun livre ne correspond à cet ID, on arrête le script
if (!$livre) { 
    die("Livre introuvable."); 
}

// Gestion de l'ajout à la liste de lecture (Action du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_liste'])) {
    $id_lecteur = 1; // On simule le lecteur Jean Dupont (ID 1)
    $date_emprunt = date('Y-m-d');
    
    // Vérification si le livre est déjà présent dans la liste
    $check = $pdo->prepare("SELECT * FROM Liste_lecture WHERE id_livre = ? AND id_lecteur = ?");
    $check->execute([$id, $id_lecteur]);
    
    if ($check->rowCount() == 0) {
        // Insertion si le livre n'y est pas encore
        $insert = $pdo->prepare("INSERT INTO Liste_lecture (id_livre, id_lecteur, date_emprunt) VALUES (?, ?, ?)");
        $insert->execute([$id, $id_lecteur, $date_emprunt]);
        echo "<script>alert('Livre ajouté à votre liste !');</script>";
    } else {
        echo "<script>alert('Ce livre est déjà dans votre liste.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($livre['titre']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1><?php echo htmlspecialchars($livre['titre']); ?></h1>
        
        <div style="margin: 20px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid var(--secondary-color);">
            <p style="margin-bottom: 8px;"><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
            <p style="margin-bottom: 8px;"><strong>Éditeur :</strong> <?php echo htmlspecialchars($livre['maison_edition']); ?></p>
            <p style="margin-bottom: 0;"><strong>Disponibles :</strong> <?php echo $livre['nombre_exemplaire']; ?> exemplaire(s)</p>
        </div>

        <h3 style="margin-top: 25px;">Description de l'ouvrage</h3>
        <p style="text-align: justify; color: #4a5568; background: #ffffff; padding: 10px 0;">
            <?php echo nl2br(htmlspecialchars($livre['description'])); ?>
        </p>

        <form method="POST" style="margin-top: 30px;">
            <button type="submit" name="ajouter_liste" class="btn">Ajouter à ma liste de lecture</button>
        </form>
        
        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="index.html" class="btn" style="background-color: #718096;">← Retour à l'accueil</a> 
            <a href="wishlist.php" class="btn" style="background-color: var(--primary-color);">Ma liste de lecture →</a>
        </div>
        
    </main>
</body>
</html>