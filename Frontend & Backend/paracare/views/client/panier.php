<!-- Page Panier -->

<section class="section">
    <div class="panier-header">
        <h2 class="section-title"><i class="fas fa-shopping-cart" style="color:#2D9CDB;"></i> Mon Panier
            <?php if (!empty($articles)): ?>
            <span class="panier-count">(<?php echo count($articles); ?> article<?php echo count($articles) > 1 ? 's' : ''; ?>)</span>
            <?php endif; ?>
        </h2>
        <?php if (!empty($articles)): ?>
        <a href="index.php?page=produits" class="continuer-achats">
            <i class="fas fa-arrow-left"></i> Continuer mes achats
        </a>
        <?php endif; ?>
    </div>

    <?php if (empty($articles)): ?>
        <div class="empty-state">
            <i class="fas fa-shopping-cart"></i>
            <h3>Votre panier est vide</h3>
            <p>Parcourez nos produits et ajoutez-les à votre panier.</p>
            <a href="index.php?page=produits" class="btn-lien">Voir les produits</a>
        </div>
    <?php else: ?>
        <div class="panier-layout">
            <!-- Liste des articles -->
            <div class="panier-articles">
                <?php foreach ($articles as $article):
                    $prix_effectif = getPrixEffectif($article);
                    $en_promo = aPromotion($article);
                ?>
                <div class="panier-item">
                    <div class="panier-item-image">
                        <img src="<?php echo imageProduit($article['image']); ?>" alt="<?php echo htmlspecialchars($article['nom']); ?>">
                    </div>
                    <div class="panier-item-infos">
                        <span class="panier-item-cat"><?php echo htmlspecialchars($article['nom_categorie'] ?? ''); ?></span>
                        <h4><?php echo htmlspecialchars($article['nom']); ?></h4>
                        <?php if ($en_promo): ?>
                        <span class="panier-item-prix">
                            <span class="prix-barre"><?php echo number_format($article['prix'], 2, ',', ' '); ?> DH</span>
                            <span class="prix-promo"><?php echo number_format($prix_effectif, 2, ',', ' '); ?> DH</span>
                        </span>
                        <?php else: ?>
                        <span class="panier-item-prix"><?php echo number_format($prix_effectif, 2, ',', ' '); ?> DH</span>
                        <?php endif; ?>
                    </div>
                    <div class="panier-item-quantite">
                        <form method="POST" action="index.php?page=panier&action=modifier" class="qte-form">
                            <input type="hidden" name="id_item" value="<?php echo $article['id_item']; ?>">
                            <button type="button" class="qte-btn" onclick="modifierQte(this, -1)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantite" value="<?php echo $article['quantite']; ?>" min="1" max="<?php echo $article['stock']; ?>" class="qte-input" readonly>
                            <button type="button" class="qte-btn" onclick="modifierQte(this, 1)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                    <div class="panier-item-sous-total">
                        <strong><?php echo number_format($prix_effectif * $article['quantite'], 2, ',', ' '); ?> DH</strong>
                    </div>
                    <div class="panier-item-supprimer">
                        <a href="index.php?page=panier&action=supprimer&id=<?php echo $article['id_item']; ?>" onclick="return confirm('Supprimer cet article ?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Resume commande -->
            <div class="panier-resume">
                <h3>Résumé de commande</h3>

                <!-- Code promo -->
                <div class="coupon-section">
                    <div class="coupon-form">
                        <input type="text" placeholder="Code promo" id="codePromo">
                        <button type="button" onclick="appliquerCoupon()">Appliquer</button>
                    </div>
                    <p id="couponMsg" class="coupon-msg"></p>
                </div>

                <div class="resume-lignes">
                    <?php if ($economie_promo > 0): ?>
                    <div class="resume-ligne resume-economie">
                        <span><i class="fas fa-tag"></i> Promotions (-15%)</span>
                        <span>-<?php echo number_format($economie_promo, 2, ',', ' '); ?> DH</span>
                    </div>
                    <?php endif; ?>
                    <div class="resume-ligne">
                        <span>Sous-total</span>
                        <span><?php echo number_format($total, 2, ',', ' '); ?> DH</span>
                    </div>
                    <div class="resume-ligne">
                        <span>Livraison</span>
                        <span class="<?php echo ($total >= 200) ? 'livraison-gratuite' : ''; ?>">
                            <?php echo ($total >= 200) ? 'Gratuite' : '29,00 DH'; ?>
                        </span>
                    </div>
                    <?php if ($total < 200): ?>
                    <p class="livraison-info">
                        <i class="fas fa-info-circle"></i>
                        Plus que <strong><?php echo number_format(200 - $total, 2, ',', ' '); ?> DH</strong> pour la livraison gratuite
                    </p>
                    <?php endif; ?>
                </div>

                <div class="resume-total">
                    <span>Total</span>
                    <span><?php echo number_format($total + ($total < 200 ? 29 : 0), 2, ',', ' '); ?> DH</span>
                </div>

                <a href="index.php?page=commande&action=checkout" class="btn-commander">
                    <i class="fas fa-lock"></i> Passer la commande
                </a>

                <div class="garanties-panier">
                    <div class="garantie-item">
                        <i class="fas fa-truck"></i>
                        <span>Livraison rapide</span>
                    </div>
                    <div class="garantie-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Paiement sécurisé</span>
                    </div>
                    <div class="garantie-item">
                        <i class="fas fa-undo"></i>
                        <span>Retour 30 jours</span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<script>
function modifierQte(btn, delta) {
    var form = btn.closest('.qte-form');
    var input = form.querySelector('.qte-input');
    var max = parseInt(input.max);
    var val = parseInt(input.value) + delta;
    if (val >= 1 && val <= max) {
        input.value = val;
        form.submit();
    }
}

function appliquerCoupon() {
    var code = document.getElementById('codePromo').value.trim().toUpperCase();
    var msg = document.getElementById('couponMsg');
    if (code === 'BIENVENUE15' || code === 'PROMO15') {
        msg.textContent = 'Code promo appliqué ! -15% sur votre commande.';
        msg.style.color = '#27AE60';
    } else if (code === '') {
        msg.textContent = 'Veuillez entrer un code.';
        msg.style.color = '#e74c3c';
    } else {
        msg.textContent = 'Code promo invalide.';
        msg.style.color = '#e74c3c';
    }
}
</script>
