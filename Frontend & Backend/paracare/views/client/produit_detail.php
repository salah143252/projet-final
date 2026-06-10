<!-- Page detail produit -->

<!-- Fil d'ariane -->
<section class="section breadcrumb-section">
    <nav class="breadcrumb">
        <a href="index.php">Accueil</a>
        <i class="fas fa-chevron-right"></i>
        <a href="index.php?page=produits">Produits</a>
        <i class="fas fa-chevron-right"></i>
        <a href="index.php?page=produits&cat=<?php echo htmlspecialchars($produit['cat_slug'] ?? ''); ?>"><?php echo htmlspecialchars($produit['nom_categorie']); ?></a>
        <i class="fas fa-chevron-right"></i>
        <span><?php echo htmlspecialchars($produit['nom']); ?></span>
    </nav>
</section>

<section class="section">
    <div class="produit-detail">
        <!-- Image du produit -->
        <div class="produit-detail-img-wrapper">
            <img src="<?php echo imageProduit($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>" class="produit-detail-image">
            <?php if (aPromotion($produit)): ?>
            <span class="badge-promo badge-promo-detail">-15%</span>
            <?php endif; ?>
        </div>

        <!-- Infos du produit -->
        <div class="produit-detail-infos">
            <span class="produit-categorie"><?php echo htmlspecialchars($produit['nom_categorie']); ?></span>
            <h1><?php echo htmlspecialchars($produit['nom']); ?></h1>

            <!-- Etoiles -->
            <?php $note_detail = getNoteProduit($produit['id_produit']); ?>
            <div class="detail-etoiles">
                <?php echo afficherEtoiles($note_detail); ?>
                <span>(<?php echo $note_detail; ?>) - 23 avis</span>
            </div>

            <?php if (aPromotion($produit)): ?>
            <p class="prix">
                <span class="prix-barre"><?php echo number_format($produit['prix'], 2, ',', ' '); ?> DH</span>
                <span class="prix-promo"><?php echo number_format(getPrixPromo($produit['prix']), 2, ',', ' '); ?> DH</span>
            </p>
            <?php else: ?>
            <p class="prix"><?php echo number_format($produit['prix'], 2, ',', ' '); ?> DH</p>
            <?php endif; ?>

            <p class="description"><?php echo nl2br(htmlspecialchars($produit['description'])); ?></p>

            <!-- Stock -->
            <?php if ($produit['stock'] > 0): ?>
                <p class="stock-info en-stock"><i class="fas fa-check-circle"></i> En stock (<?php echo $produit['stock']; ?> disponibles)</p>
            <?php else: ?>
                <p class="stock-info rupture"><i class="fas fa-times-circle"></i> Rupture de stock</p>
            <?php endif; ?>

            <!-- Formulaire ajout au panier -->
            <?php if (isset($_SESSION['id_user']) && $produit['stock'] > 0): ?>
            <form method="POST" action="index.php?page=panier&action=ajouter">
                <input type="hidden" name="id_produit" value="<?php echo $produit['id_produit']; ?>">

                <div class="quantite-selector">
                    <label>Quantité :</label>
                    <button type="button" onclick="diminuerQte()">-</button>
                    <input type="number" name="quantite" id="quantite" value="1" min="1" max="<?php echo $produit['stock']; ?>">
                    <button type="button" onclick="augmenterQte(<?php echo $produit['stock']; ?>)">+</button>
                </div>

                <div class="detail-buttons">
                    <button type="submit" class="btn-ajouter-panier">
                        <i class="fas fa-cart-plus"></i> Ajouter au panier
                    </button>
                    <a href="index.php?page=commande&action=checkout" class="btn-acheter">
                        <i class="fas fa-bolt"></i> Acheter maintenant
                    </a>
                </div>
            </form>
            <?php elseif (!isset($_SESSION['id_user'])): ?>
                <p style="margin-top:15px;"><a href="index.php?page=connexion" class="btn-lien"><i class="fas fa-user"></i> Connectez-vous pour acheter</a></p>
            <?php endif; ?>

            <!-- Caractéristiques du produit -->
            <div class="produit-features">
                <div class="feature-item">
                    <i class="fas fa-flask"></i>
                    <span>Produit certifié</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-leaf"></i>
                    <span>Ingrédients naturels</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-truck"></i>
                    <span>Livraison rapide</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-undo"></i>
                    <span>Retour 30 jours</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Onglets details produit -->
<section class="section">
    <div class="onglets-container">
        <div class="onglets-nav">
            <button class="onglet-btn active" onclick="ouvrirOnglet(event, 'onglet-description')">Description</button>
            <button class="onglet-btn" onclick="ouvrirOnglet(event, 'onglet-conseils')">Conseils d'utilisation</button>
            <button class="onglet-btn" onclick="ouvrirOnglet(event, 'onglet-avis')">Avis clients (23)</button>
        </div>

        <div id="onglet-description" class="onglet-content active">
            <h3>Description complète</h3>
            <p><?php echo nl2br(htmlspecialchars($produit['description'])); ?></p>
            <div class="description-details">
                <div class="desc-row">
                    <span class="desc-label">Catégorie</span>
                    <span class="desc-value"><?php echo htmlspecialchars($produit['nom_categorie']); ?></span>
                </div>
                <div class="desc-row">
                    <span class="desc-label">Référence</span>
                    <span class="desc-value">PC-<?php echo str_pad($produit['id_produit'], 4, '0', STR_PAD_LEFT); ?></span>
                </div>
                <div class="desc-row">
                    <span class="desc-label">Disponibilité</span>
                    <span class="desc-value"><?php echo $produit['stock'] > 0 ? 'En stock (' . $produit['stock'] . ' unités)' : 'Rupture'; ?></span>
                </div>
            </div>
        </div>

        <div id="onglet-conseils" class="onglet-content">
            <h3>Conseils d'utilisation</h3>
            <ul class="conseils-list">
                <li><i class="fas fa-check-circle"></i> Appliquer sur une peau propre et sèche</li>
                <li><i class="fas fa-check-circle"></i> Utiliser matin et soir pour des résultats optimaux</li>
                <li><i class="fas fa-check-circle"></i> Conserver dans un endroit frais et sec</li>
                <li><i class="fas fa-check-circle"></i> Éviter le contact avec les yeux</li>
                <li><i class="fas fa-check-circle"></i> Ne pas utiliser en cas d'allergie connue à un ingrédient</li>
            </ul>
        </div>

        <div id="onglet-avis" class="onglet-content">
            <h3>Avis de nos clients</h3>
            <div class="avis-summary">
                <div class="avis-note">
                    <span class="note-chiffre"><?php echo $note_detail; ?></span>
                    <div class="note-etoiles"><?php echo afficherEtoiles($note_detail); ?></div>
                    <span class="note-count">23 avis</span>
                </div>
            </div>
            <div class="avis-produit">
                <div class="avis-item">
                    <div class="avis-header">
                        <div class="avis-avatar">AK</div>
                        <div>
                            <strong>Amina K.</strong>
                            <div class="avis-etoiles"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        </div>
                    </div>
                    <p>Très bon produit, je l'utilise depuis 2 semaines et je vois déjà la différence. La texture est agréable et l'odeur est douce. Je recommande vivement !</p>
                </div>
                <div class="avis-item">
                    <div class="avis-header">
                        <div class="avis-avatar">YM</div>
                        <div>
                            <strong>Youssef M.</strong>
                            <div class="avis-etoiles"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i></div>
                        </div>
                    </div>
                    <p>Bonne qualité pour le prix. Livraison rapide et emballage soigné. Satisfait de mon achat, je commanderai à nouveau.</p>
                </div>
                <div class="avis-item">
                    <div class="avis-header">
                        <div class="avis-avatar">SB</div>
                        <div>
                            <strong>Sara B.</strong>
                            <div class="avis-etoiles"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                        </div>
                    </div>
                    <p>Excellent rapport qualité-prix ! Ma peau est beaucoup plus douce depuis que j'utilise ce produit. Seul bémol : l'odeur est un peu forte au début.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produits similaires -->
<?php if (!empty($produits_similaires)): ?>
<section class="section">
    <h2 class="section-title">Produits similaires</h2>
    <div class="produits-grid">
        <?php foreach ($produits_similaires as $prod): ?>
            <?php require 'views/partials/produit_card.php'; ?>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
