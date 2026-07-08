<?php 
require 'db.php'; 

$search = isset($_GET['query']) ? trim($_GET['query']) : '';
$livres = [];

if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT id, titre, auteur FROM livres WHERE titre LIKE :search OR auteur LIKE :search");
    $stmt->execute(['search' => '%' . $search . '%']);
    
    // Correction de sécurité : parenthèses laissées vides pour éviter tout conflit de constante PDO
    $livres = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h2>Résultats pour : "<?php echo htmlspecialchars($search); ?>"</h2>
        <a href="index.html" class="btn" style="background-color: #718096; margin-bottom: 20px;">← Retour à l'accueil</a>

        <div class="results-list">
            <?php if (!empty($livres)): ?>
                <?php foreach ($livres as $livre): ?>
                    <div class="book-card">
                        <div>
                            <h3><?php echo htmlspecialchars($livre['titre']); ?></h3>
                            <p>Par : <?php echo htmlspecialchars($livre['auteur']); ?></p>
                        </div>
                        <a href="details.php?id=<?php echo $livre['id']; ?>" class="btn">Voir les détails</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; padding: 20px; background: #f8fafc; border-radius: 8px;">
                    Aucun livre trouvé pour cette recherche.
                </p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>