<!-- Page Checkout -->

<section class="section">
    <h2 class="section-title"><i class="fas fa-lock" style="color:#27AE60;"></i> Paiement sécurisé</h2>

    <?php if (isset($erreur) && $erreur): ?>
        <div class="alert alert-erreur"><?php echo $erreur; ?></div>
    <?php endif; ?>

    <div class="checkout-container">
        <!-- Formulaire de livraison -->
        <div class="checkout-form">
            <h3><i class="fas fa-map-marker-alt" style="color:#2D9CDB;"></i> Adresse de livraison</h3>

            <form method="POST" action="index.php?page=commande&action=passer">
                <div class="form-group">
                    <label for="adresse_livraison">Adresse complète *</label>
                    <textarea name="adresse_livraison" id="adresse_livraison" rows="3" required
                              placeholder="Rue, numéro, ville, code postal..."><?php echo isset($_SESSION['adresse']) ? htmlspecialchars($_SESSION['adresse']) : ''; ?></textarea>
                </div>

                <!-- Mode de paiement (simulation) -->
                <div class="form-group" style="margin-top:20px;">
                    <label><i class="fas fa-credit-card" style="color:#2D9CDB;"></i> Mode de paiement</label>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-top:8px;">
                        <label style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:2px solid #2D9CDB; border-radius:8px; cursor:pointer; background:#f0f8ff;">
                            <input type="radio" name="paiement" value="livraison" checked style="accent-color:#2D9CDB;">
                            <i class="fas fa-truck" style="color:#2D9CDB;"></i>
                            <span style="font-size:14px; font-weight:500;">Paiement à la livraison</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:1px solid #ddd; border-radius:8px; cursor:pointer;">
                            <input type="radio" name="paiement" value="carte" style="accent-color:#2D9CDB;">
                            <i class="fab fa-cc-visa" style="color:#1a1f71;"></i>
                            <span style="font-size:14px; font-weight:500;">Carte bancaire</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; padding:12px 15px; border:1px solid #ddd; border-radius:8px; cursor:pointer;">
                            <input type="radio" name="paiement" value="virement" style="accent-color:#2D9CDB;">
                            <i class="fas fa-university" style="color:#555;"></i>
                            <span style="font-size:14px; font-weight:500;">Virement bancaire</span>
                        </label>
                    </div>
                </div>

                <!-- Garanties -->
                <div style="display:flex; gap:15px; margin-top:20px; padding:15px; background:#f8f9fa; border-radius:8px;">
                    <span style="font-size:12px; color:#888; display:flex; align-items:center; gap:5px;">
                        <i class="fas fa-shield-alt" style="color:#27AE60;"></i> Paiement sécurisé
                    </span>
                    <span style="font-size:12px; color:#888; display:flex; align-items:center; gap:5px;">
                        <i class="fas fa-undo" style="color:#2D9CDB;"></i> Retour 30 jours
                    </span>
                    <span style="font-size:12px; color:#888; display:flex; align-items:center; gap:5px;">
                        <i class="fas fa-truck" style="color:#f39c12;"></i> Livraison rapide
                    </span>
                </div>

                <button type="submit" class="btn-commander" style="width:100%; margin-top:20px; font-size:16px;">
                    <i class="fas fa-lock"></i> Confirmer la commande
                </button>
            </form>
        </div>

        <!-- Resume de la commande -->
        <div class="checkout-resume">
            <h3><i class="fas fa-receipt" style="color:#2D9CDB;"></i> Résumé de commande</h3>

            <?php
            $economie_checkout = 0;
            foreach ($articles as $art):
                $prix_effectif = getPrixEffectif($art);
                if (aPromotion($art)) {
                    $economie_checkout += ($art['prix'] - $prix_effectif) * $art['quantite'];
                }
            ?>
            <div class="article-resume">
                <span><?php echo htmlspecialchars($art['nom']); ?> <strong style="color:#888;">×<?php echo $art['quantite']; ?></strong></span>
                <span>
                    <?php if (aPromotion($art)): ?>
                    <span class="prix-barre" style="font-size:12px;"><?php echo number_format($art['prix'] * $art['quantite'], 2, ',', ' '); ?> DH</span>
                    <?php endif; ?>
                    <?php echo number_format($prix_effectif * $art['quantite'], 2, ',', ' '); ?> DH
                </span>
            </div>
            <?php endforeach; ?>

            <!-- Sous-total, livraison, total -->
            <div style="margin-top:15px; padding-top:15px; border-top:1px solid #eee;">
                <?php if ($economie_checkout > 0): ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px; color:#27AE60;">
                    <span><i class="fas fa-tag"></i> Économies promo</span>
                    <span>-<?php echo number_format($economie_checkout, 2, ',', ' '); ?> DH</span>
                </div>
                <?php endif; ?>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px;">
                    <span style="color:#666;">Sous-total</span>
                    <span><?php echo number_format($total, 2, ',', ' '); ?> DH</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; font-size:14px;">
                    <span style="color:#666;">Livraison</span>
                    <span style="color:#27AE60;"><?php echo ($total >= 200) ? 'Gratuite' : '29,00 DH'; ?></span>
                </div>
                <?php if ($total < 200): ?>
                <div style="font-size:12px; color:#888; margin-bottom:10px;">
                    <i class="fas fa-info-circle" style="color:#2D9CDB;"></i>
                    Encore <?php echo number_format(200 - $total, 2, ',', ' '); ?> DH pour la livraison gratuite
                </div>
                <?php endif; ?>
            </div>

            <div class="total-final">
                <span>Total TTC</span>
                <span><?php echo number_format($total + ($total < 200 ? 29 : 0), 2, ',', ' '); ?> DH</span>
            </div>

            <!-- Info client -->
            <div style="margin-top:20px; padding:12px; background:#f8f9fa; border-radius:8px; font-size:13px; color:#666;">
                <p><i class="fas fa-user" style="color:#2D9CDB;"></i> <?php echo htmlspecialchars($_SESSION['nom_complet']); ?></p>
                <p style="margin-top:5px;"><i class="fas fa-envelope" style="color:#2D9CDB;"></i> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
        </div>
    </div>
</section>
