<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit - ParaCare Admin</title>
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
            <h1>Ajouter un produit</h1>
            <a href="index.php?page=admin&action=produits" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <!-- Message d'erreur -->
        <?php if (!empty($erreur)): ?>
            <div class="alert alert-erreur"><?php echo $erreur; ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout -->
        <div class="admin-form">
            <form method="POST" action="index.php?page=admin&action=ajouter_produit" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom du produit *</label>
                    <input type="text" name="nom" id="nom" placeholder="Ex: Creme hydratante..." required>
                </div>

                <div class="form-group">
                    <label for="description">Description *</label>
                    <textarea name="description" id="description" placeholder="Décrivez le produit..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="prix">Prix (DH) *</label>
                    <input type="number" name="prix" id="prix" step="0.01" min="0" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" name="stock" id="stock" min="0" placeholder="0" required>
                </div>

                <div class="form-group">
                    <label for="id_categorie">Catégorie *</label>
                    <select name="id_categorie" id="id_categorie" required>
                        <option value="">-- Choisir une catégorie --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id_categorie']; ?>">
                                <?php echo htmlspecialchars($cat['nom_categorie']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Image du produit</label>
                    <input type="file" name="image" id="image" accept="image/*">
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-plus"></i> Ajouter le produit
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
