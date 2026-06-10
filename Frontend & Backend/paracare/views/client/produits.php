<!-- Page catalogue produits -->

<section class="section">
    <div class="catalogue-header">
        <h2 class="section-title">Tous les produits</h2>
        <?php if ($categorie_filtre): ?>
        <span class="catalogue-badge">
            <?php
            foreach ($categories as $c) {
                if ($c['slug'] == $categorie_filtre) {
                    echo htmlspecialchars($c['nom_categorie']);
                    break;
                }
            }
            ?>
            <a href="index.php?page=produits" title="Effacer le filtre">&times;</a>
        </span>
        <?php endif; ?>
    </div>

    <div class="catalogue-container">
        <!-- Sidebar filtres -->
        <aside class="filtres-sidebar">
            <div class="filtres-header">
                <h3><i class="fas fa-sliders-h"></i> Filtres</h3>
            </div>

            <!-- Filtre categories -->
            <div class="filtre-block">
                <h3>Catégorie</h3>
                <ul>
                    <li><a href="index.php?page=produits" class="<?php echo !$categorie_filtre ? 'active' : ''; ?>">
                        <i class="fas fa-th"></i> Toutes
                    </a></li>
                    <?php foreach ($categories as $cat): ?>
                    <li>
                        <a href="index.php?page=produits&cat=<?php echo $cat['slug']; ?>" class="<?php echo ($categorie_filtre == $cat['slug']) ? 'active' : ''; ?>">
                            <i class="fas fa-chevron-right"></i> <?php echo htmlspecialchars($cat['nom_categorie']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Filtre prix -->
            <div class="filtre-block">
                <h3>Prix</h3>
                <ul>
                    <?php
                    $base_url = 'index.php?page=produits';
                    if ($categorie_filtre) $base_url .= '&cat=' . $categorie_filtre;
                    if ($recherche) $base_url .= '&recherche=' . urlencode($recherche);
                    if (isset($note_filtre) && $note_filtre) $base_url .= '&note=' . $note_filtre;
                    ?>
                    <li><a href="<?php echo $base_url; ?>" class="<?php echo !isset($prix_filtre) || !$prix_filtre ? 'active' : ''; ?>">Tous les prix</a></li>
                    <li><a href="<?php echo $base_url; ?>&prix=moins50" class="<?php echo (isset($prix_filtre) && $prix_filtre == 'moins50') ? 'active' : ''; ?>">Moins de 50 DH</a></li>
                    <li><a href="<?php echo $base_url; ?>&prix=50-100" class="<?php echo (isset($prix_filtre) && $prix_filtre == '50-100') ? 'active' : ''; ?>">50 - 100 DH</a></li>
                    <li><a href="<?php echo $base_url; ?>&prix=100-200" class="<?php echo (isset($prix_filtre) && $prix_filtre == '100-200') ? 'active' : ''; ?>">100 - 200 DH</a></li>
                    <li><a href="<?php echo $base_url; ?>&prix=plus200" class="<?php echo (isset($prix_filtre) && $prix_filtre == 'plus200') ? 'active' : ''; ?>">Plus de 200 DH</a></li>
                </ul>
            </div>

            <!-- Filtre note (etoiles) -->
            <div class="filtre-block">
                <h3>Note</h3>
                <ul class="filtre-etoiles">
                    <?php
                    $note_base = 'index.php?page=produits';
                    if ($categorie_filtre) $note_base .= '&cat=' . $categorie_filtre;
                    if ($recherche) $note_base .= '&recherche=' . urlencode($recherche);
                    if (isset($prix_filtre) && $prix_filtre) $note_base .= '&prix=' . $prix_filtre;
                    ?>
                    <li><a href="<?php echo $note_base; ?>&note=5" class="<?php echo (isset($note_filtre) && $note_filtre == 5) ? 'active' : ''; ?>"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> &amp; plus</a></li>
                    <li><a href="<?php echo $note_base; ?>&note=4" class="<?php echo (isset($note_filtre) && $note_filtre == 4) ? 'active' : ''; ?>"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i> &amp; plus</a></li>
                    <li><a href="<?php echo $note_base; ?>&note=3" class="<?php echo (isset($note_filtre) && $note_filtre == 3) ? 'active' : ''; ?>"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i> &amp; plus</a></li>
                </ul>
            </div>

            <!-- Banniere promo sidebar -->
            <div class="filtre-promo">
                <i class="fas fa-percent"></i>
                <h4>Offre spéciale</h4>
                <p>-15% sur tous les soins</p>
                <a href="index.php?page=produits&cat=skincare">En profiter</a>
            </div>
        </aside>

        <!-- Contenu principal -->
        <div class="catalogue-produits">
            <!-- Barre de recherche + tri -->
            <div class="catalogue-toolbar">
                <form class="search-bar" method="GET" action="index.php">
                    <input type="hidden" name="page" value="produits">
                    <?php if ($categorie_filtre): ?><input type="hidden" name="cat" value="<?php echo htmlspecialchars($categorie_filtre); ?>"><?php endif; ?>
                    <input type="text" name="recherche" placeholder="Rechercher un produit..." value="<?php echo isset($recherche) ? htmlspecialchars($recherche) : ''; ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
                <div class="catalogue-sort">
                    <label>Trier par :</label>
                    <select onchange="trierCatalogue(this.value)">
                        <option value="recent">Plus récents</option>
                        <option value="prix-asc">Prix croissant</option>
                        <option value="prix-desc">Prix décroissant</option>
                        <option value="nom">Nom A-Z</option>
                    </select>
                </div>
            </div>

            <?php if (empty($produits)): ?>
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    <h3>Aucun produit trouvé</h3>
                    <p>Essayez avec d'autres critères de recherche.</p>
                </div>
            <?php else: ?>
                <!-- Nombre de resultats -->
                <p class="resultats-count"><?php echo $total_produits; ?> produit(s) trouvé(s)</p>

                <div class="produits-grid">
                    <?php foreach ($produits as $prod): ?>
                        <?php require 'views/partials/produit_card.php'; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php
                    $pag_base = 'index.php?page=produits';
                    if ($categorie_filtre) $pag_base .= '&cat=' . $categorie_filtre;
                    if ($recherche) $pag_base .= '&recherche=' . urlencode($recherche);
                    if (isset($prix_filtre) && $prix_filtre) $pag_base .= '&prix=' . $prix_filtre;
                    if (isset($note_filtre) && $note_filtre) $pag_base .= '&note=' . $note_filtre;
                    ?>
                    <?php if ($page_num > 1): ?>
                    <a href="<?php echo $pag_base; ?>&p=<?php echo $page_num - 1; ?>" class="page-btn"><i class="fas fa-chevron-left"></i></a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="<?php echo $pag_base; ?>&p=<?php echo $i; ?>" class="page-btn <?php echo ($i == $page_num) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>

                    <?php if ($page_num < $total_pages): ?>
                    <a href="<?php echo $pag_base; ?>&p=<?php echo $page_num + 1; ?>" class="page-btn"><i class="fas fa-chevron-right"></i></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Banniere CTA bas de page -->
<section class="cta-banner">
    <h2>Venez découvrir tous nos produits de parapharmacie</h2>
    <p>Skincare, Haircare, Body Care et Vitamines - tout pour votre bien-être.</p>
    <a href="index.php?page=produits" class="btn-catalogue" style="display: inline-flex !important; align-items: center !important; gap: 12px !important; background: linear-gradient(135deg, #2D9CDB 0%, #27AE60 100%) !important; color: #ffffff !important; padding: 16px 40px !important; border-radius: 50px !important; font-weight: 600 !important; font-size: 16px !important; text-decoration: none !important; box-shadow: 0 8px 25px rgba(45, 156, 219, 0.4) !important; position: relative !important; overflow: hidden !important; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;">
        <i class="fas fa-shopping-bag" style="font-size: 18px !important; color: #ffffff !important;"></i>
        <span style="color: #ffffff !important; position: relative !important; z-index: 1 !important;">Explorer le catalogue</span>
    </a>
</section>

<script>
function trierCatalogue(critere) {
    var grid = document.querySelector('.produits-grid');
    var cards = Array.from(grid.querySelectorAll('.produit-card'));
    cards.sort(function(a, b) {
        var prixA = parseFloat(a.querySelector('.produit-prix').textContent.replace(/[^\d.]/g, '')) || 0;
        var prixB = parseFloat(b.querySelector('.produit-prix').textContent.replace(/[^\d.]/g, '')) || 0;
        var nomA = a.querySelector('.produit-nom').textContent.toLowerCase();
        var nomB = b.querySelector('.produit-nom').textContent.toLowerCase();
        if (critere === 'prix-asc') return prixA - prixB;
        if (critere === 'prix-desc') return prixB - prixA;
        if (critere === 'nom') return nomA.localeCompare(nomB);
        return 0;
    });
    cards.forEach(function(card) { grid.appendChild(card); });
}
</script>
