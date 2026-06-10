<?php
// Partial : carte produit reutilisable
$note = getNoteProduit($prod['id_produit']);
$en_promo = aPromotion($prod);
?>
<div class="produit-card">
    <?php if ($en_promo): ?>
    <span class="badge-promo">-15%</span>
    <?php endif; ?>
    <a href="index.php?page=produit&id=<?php echo $prod['id_produit']; ?>">
        <img src="<?php echo imageProduit($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['nom']); ?>" class="produit-image">
    </a>
    <div class="produit-info">
        <span class="produit-categorie"><?php echo htmlspecialchars($prod['nom_categorie']); ?></span>
        <h3 class="produit-nom"><?php echo htmlspecialchars($prod['nom']); ?></h3>
        <div class="produit-etoiles"><?php echo afficherEtoiles($note); ?></div>
        <?php if ($en_promo): ?>
        <p class="produit-prix">
            <span class="prix-barre"><?php echo number_format($prod['prix'], 2, ',', ' '); ?> DH</span>
            <span class="prix-promo"><?php echo number_format(getPrixPromo($prod['prix']), 2, ',', ' '); ?> DH</span>
        </p>
        <?php else: ?>
        <p class="produit-prix"><?php echo number_format($prod['prix'], 2, ',', ' '); ?> DH</p>
        <?php endif; ?>
    </div>
    <?php if (isset($_SESSION['id_user'])): ?>
    <form method="POST" action="index.php?page=panier&action=ajouter">
        <input type="hidden" name="id_produit" value="<?php echo $prod['id_produit']; ?>">
        <input type="hidden" name="quantite" value="1">
        <button type="submit" class="btn-ajouter" title="Ajouter au panier">
            <i class="fas fa-plus"></i>
        </button>
    </form>
    <?php endif; ?>
</div>
