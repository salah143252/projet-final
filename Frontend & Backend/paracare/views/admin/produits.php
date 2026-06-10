<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Produits - ParaCare Admin</title>
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
            <div>
                <h1>Gestion des Produits</h1>
                <p style="color:#888; font-size:13px; margin-top:3px;"><?php echo count($produits); ?> produit(s) au catalogue</p>
            </div>
            <a href="index.php?page=admin&action=ajouter_produit" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un produit
            </a>
        </div>

        <!-- Barre de recherche -->
        <div class="admin-search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="searchProduits" placeholder="Rechercher par nom, catégorie..." onkeyup="filterProducts()">
            <select id="filterCategorie" onchange="filterProducts()">
                <option value="">Toutes catégories</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?php echo htmlspecialchars($cat['nom_categorie']); ?>"><?php echo htmlspecialchars($cat['nom_categorie']); ?></option>
                <?php endforeach; ?>
            </select>
            <select id="filterStock" onchange="filterProducts()">
                <option value="">Tout stock</option>
                <option value="instock">En stock</option>
                <option value="outofstock">Rupture</option>
            </select>
        </div>

        <!-- Tableau des produits -->
        <?php if (empty($produits)): ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>Aucun produit pour le moment</h3>
                <p>Commencez par ajouter votre premier produit.</p>
            </div>
        <?php else: ?>
            <table class="admin-table" id="tableProduits">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $prod): ?>
                    <tr data-nom="<?php echo htmlspecialchars(strtolower($prod['nom'])); ?>" data-cat="<?php echo htmlspecialchars(strtolower($prod['nom_categorie'])); ?>" data-stock="<?php echo $prod['stock']; ?>">
                        <td>
                            <img src="<?php echo imageProduit($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['nom']); ?>">
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($prod['nom']); ?></strong>
                            <br><small style="color:#888;">ID: <?php echo $prod['id_produit']; ?></small>
                        </td>
                        <td>
                            <span class="cat-badge"><?php echo htmlspecialchars($prod['nom_categorie']); ?></span>
                        </td>
                        <td><strong><?php echo number_format($prod['prix'], 2, ',', ' '); ?> DH</strong></td>
                        <td>
                            <?php if ($prod['stock'] > 0): ?>
                                <div class="stock-bar-wrapper">
                                    <div class="stock-bar" style="width:<?php echo min(100, $prod['stock'] * 2); ?>%; background:<?php echo $prod['stock'] > 20 ? '#27AE60' : ($prod['stock'] > 5 ? '#f39c12' : '#e74c3c'); ?>;"></div>
                                </div>
                                <span style="font-size:12px; color:<?php echo $prod['stock'] > 20 ? '#27AE60' : ($prod['stock'] > 5 ? '#f39c12' : '#e74c3c'); ?>;">
                                    <?php echo $prod['stock']; ?> unité(s)
                                </span>
                            <?php else: ?>
                                <span class="stock-rupture"><i class="fas fa-times-circle"></i> Rupture</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=admin&action=modifier_produit&id=<?php echo $prod['id_produit']; ?>" class="btn btn-warning btn-sm" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?page=admin&action=supprimer_produit&id=<?php echo $prod['id_produit']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<script>
function filterProducts() {
    var search = document.getElementById('searchProduits').value.toLowerCase();
    var cat = document.getElementById('filterCategorie').value.toLowerCase();
    var stock = document.getElementById('filterStock').value;
    var rows = document.querySelectorAll('#tableProduits tbody tr');
    rows.forEach(function(row) {
        var nom = row.getAttribute('data-nom');
        var rowCat = row.getAttribute('data-cat');
        var rowStock = parseInt(row.getAttribute('data-stock'));
        var show = true;
        if (search && nom.indexOf(search) === -1) show = false;
        if (cat && rowCat.indexOf(cat) === -1) show = false;
        if (stock === 'instock' && rowStock <= 0) show = false;
        if (stock === 'outofstock' && rowStock > 0) show = false;
        row.style.display = show ? '' : 'none';
    });
}
</script>

</body>
</html>
