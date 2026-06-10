<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le produit - ParaCare Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <?php require_once 'views/admin/sidebar.php'; ?>

    <!-- Contenu principal -->
    <div class="admin-content">
        <div class="admin-header">
            <h1>Modifier le produit</h1>
            <a href="index.php?page=admin&action=produits" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <!-- Formulaire de modification -->
        <div class="admin-form">
            <form method="POST" action="index.php?page=admin&action=modifier_produit&id=<?php echo $produit['id_produit']; ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom du produit *</label>
                    <input type="text" name="nom" id="nom" value="<?php echo htmlspecialchars($produit['nom']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" required><?php echo htmlspecialchars($produit['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (DH) *</label>
                    <input type="number" name="prix" id="prix" step="0.01" min="0" value="<?php echo $produit['prix']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" name="stock" id="stock" min="0" value="<?php echo $produit['stock']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="id_categorie">Catégorie *</label>
                    <select name="id_categorie" id="id_categorie" required>
                        <option value="">-- Choisir une catégorie --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id_categorie']; ?>" <?php echo ($cat['id_categorie'] == $produit['id_categorie']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nom_categorie']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Image du produit</label>
                    <p style="font-size:13px; color:#888; margin-bottom:8px;">
                        Image actuelle : <strong><?php echo $produit['image']; ?></strong>
                        <br>Laissez vide pour garder l'image actuelle.
                    </p>
                    <input type="file" name="image" id="image" accept="image/*">
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
