<!-- Page d'accueil - ParaCare -->

<!-- Section Hero avec image et statistiques -->
<section class="hero-banner">
    <div class="hero-content">
        <h1>Votre bien-être, notre priorité</h1>
        <p>Découvrez notre sélection de produits de parapharmacie pour prendre soin de votre santé et beauté au quotidien.</p>
        <button type="button" class="btn-hero" onclick="window.location.href='index.php?page=produits'">Découvrir nos produits</button>

        <!-- Compteurs statistiques -->
        <div class="hero-stats">
            <div class="hero-stat">
                <strong><?php echo $stats_hero['produits']; ?>+</strong>
                <span>Produits</span>
            </div>
            <div class="hero-stat">
                <strong><?php echo $stats_hero['clients']; ?></strong>
                <span>Clients satisfaits</span>
            </div>
            <div class="hero-stat">
                <strong><?php echo $stats_hero['satisfaction']; ?></strong>
                <span>Satisfaction</span>
            </div>
            <div class="hero-stat">
                <strong>15%</strong>
                <span>Promo soins</span>
            </div>
        </div>
    </div>
    <div class="hero-image">
        <img src="assets/images/hero-produits.png" alt="Produits ParaCare">
    </div>
</section>

<!-- Section Categories (cercles avec images) -->
<section class="section">
    <h2 class="section-title">Nos Catégories</h2>
    <div class="categories-circles">
        <?php foreach ($categories as $cat): ?>
        <a href="index.php?page=produits&cat=<?php echo $cat['slug']; ?>" class="cat-circle">
            <div class="cat-circle-img">
                <img src="<?php echo imageCategorie($cat['slug']); ?>" alt="<?php echo htmlspecialchars($cat['nom_categorie']); ?>">
            </div>
            <span><?php echo htmlspecialchars($cat['nom_categorie']); ?></span>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Section Produits en vedette -->
<section class="section">
    <div class="section-header">
        <h2 class="section-title">Produits en vedette</h2>
        <a href="index.php?page=produits" class="voir-tout">Voir tout <i class="fas fa-arrow-right"></i></a>
    </div>

    <?php if (empty($produits_recents)): ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h3>Aucun produit pour le moment</h3>
            <p>Les produits seront bientôt disponibles.</p>
        </div>
    <?php else: ?>
        <div class="produits-grid">
            <?php foreach ($produits_recents as $prod): ?>
                <?php require 'views/partials/produit_card.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Section Banniere Promotion -->
<section class="promo-banner">
    <div class="promo-content">
        <span class="promo-badge">Offre spéciale</span>
        <h2>15% de réduction sur toute la collection soins</h2>
        <p>Profitez de notre offre limitée sur tous les produits de skincare, haircare et body care.</p>
        <a href="index.php?page=produits&cat=skincare" class="btn-promo">Profiter de l'offre</a>
    </div>
    <div class="promo-image">
        <img src="assets/images/promo-soins.png" alt="Promotion ParaCare">
    </div>
</section>

<!-- Section Avis clients -->
<section class="section">
    <h2 class="section-title">Ce que disent nos clients</h2>
    <div class="avis-grid">
        <div class="avis-card">
            <div class="avis-etoiles">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p>"Excellente qualité de produits ! Ma peau n'a jamais été aussi belle. Je recommande vivement ParaCare."</p>
            <div class="avis-auteur">
                <strong>Sarah M.</strong>
                <span>Cliente fidèle</span>
            </div>
        </div>
        <div class="avis-card">
            <div class="avis-etoiles">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p>"Livraison rapide et produits bien emballés. Les vitamines sont très efficaces, je me sens en pleine forme !"</p>
            <div class="avis-auteur">
                <strong>Karim B.</strong>
                <span>Client depuis 2025</span>
            </div>
        </div>
        <div class="avis-card">
            <div class="avis-etoiles">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p>"J'adore les produits naturels proposés. Le service client est très réactif et les prix sont très compétitifs."</p>
            <div class="avis-auteur">
                <strong>Fatima Z.</strong>
                <span>Cliente satisfaite</span>
            </div>
        </div>
    </div>
</section>

<!-- Section Infos (service client, livraison, paiement) -->
<section class="infos-section">
    <div class="infos-grid">
        <div class="info-block">
            <i class="fas fa-truck"></i>
            <h4>Livraison gratuite</h4>
            <p>À partir de 200 DH d'achat, livraison gratuite partout au Maroc.</p>
        </div>
        <div class="info-block">
            <i class="fas fa-shield-alt"></i>
            <h4>Paiement sécurisé</h4>
            <p>Vos transactions sont protégées et sécurisées à 100%.</p>
        </div>
        <div class="info-block">
            <i class="fas fa-headset"></i>
            <h4>Service client</h4>
            <p>Notre équipe est disponible du lundi au samedi pour vous aider.</p>
        </div>
        <div class="info-block">
            <i class="fas fa-undo"></i>
            <h4>Retour facile</h4>
            <p>Retour gratuit sous 30 jours si le produit ne vous convient pas.</p>
        </div>
    </div>
</section>

<!-- Section Pourquoi ParaCare -->
<section class="section pourquoi-section">
    <h2 class="section-title">Pourquoi choisir ParaCare ?</h2>
    <div class="pourquoi-grid">
        <div class="pourquoi-card">
            <div class="pourquoi-icon">
                <i class="fas fa-flask"></i>
            </div>
            <h4>Produits certifiés</h4>
            <p>Tous nos produits sont sélectionnés auprès de laboratoires pharmaceutiques reconnus et certifiés.</p>
        </div>
        <div class="pourquoi-card">
            <div class="pourquoi-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <h4>Ingrédients naturels</h4>
            <p>Nous privilégions les formules à base d'ingrédients naturels, sans parabens ni substances nocives.</p>
        </div>
        <div class="pourquoi-card">
            <div class="pourquoi-icon">
                <i class="fas fa-tags"></i>
            </div>
            <h4>Meilleurs prix</h4>
            <p>Des prix compétitifs toute l'année avec des promotions exclusives sur nos catégories phares.</p>
        </div>
        <div class="pourquoi-card">
            <div class="pourquoi-icon">
                <i class="fas fa-user-md"></i>
            </div>
            <h4>Conseils d'experts</h4>
            <p>Notre équipe de pharmaciens vous accompagne dans le choix des produits adaptés à vos besoins.</p>
        </div>
    </div>
</section>

<!-- Section Marques partenaires -->
<section class="marques-section">
    <div class="container">
        <h2 class="section-title">Nos marques partenaires</h2>
        <div class="marques-grid">
            <div class="marque-item">
                <i class="fas fa-prescription-bottle-alt"></i>
                <span>La Roche-Posay</span>
            </div>
            <div class="marque-item">
                <i class="fas fa-pump-medical"></i>
                <span>Bioderma</span>
            </div>
            <div class="marque-item">
                <i class="fas fa-mortar-pestle"></i>
                <span>Avène</span>
            </div>
            <div class="marque-item">
                <i class="fas fa-capsules"></i>
                <span>Vichy</span>
            </div>
            <div class="marque-item">
                <i class="fas fa-seedling"></i>
                <span>Nuxe</span>
            </div>
            <div class="marque-item">
                <i class="fas fa-heartbeat"></i>
                <span>CeraVe</span>
            </div>
        </div>
    </div>
</section>
