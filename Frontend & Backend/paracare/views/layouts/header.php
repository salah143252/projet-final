<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaCare - Parapharmacie en Ligne</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome pour les icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Notre CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Custom Button Styles -->
    <style>
    .btn-catalogue {
        display: inline-flex !important;
        align-items: center !important;
        gap: 12px !important;
        background: linear-gradient(135deg, #2D9CDB 0%, #27AE60 100%) !important;
        color: #fff !important;
        padding: 16px 40px !important;
        border-radius: 50px !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        text-decoration: none !important;
        box-shadow: 0 8px 25px rgba(45, 156, 219, 0.4) !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    }

    .btn-catalogue:hover {
        transform: translateY(-4px) scale(1.02) !important;
        box-shadow: 0 12px 35px rgba(45, 156, 219, 0.5) !important;
        background: linear-gradient(135deg, #2488c4 0%, #229954 100%) !important;
    }

    .btn-catalogue i {
        font-size: 18px !important;
        transition: transform 0.3s ease !important;
    }

    .btn-catalogue:hover i {
        transform: translateX(4px) !important;
    }
    </style>
</head>
<body>

<!-- Header -->
<header class="header">
    <div class="container">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <img src="assets/images/logo.svg" alt="ParaCare">
            <span>ParaCare</span>
        </a>

        <!-- Barre de recherche -->
        <form class="nav-search" method="GET" action="index.php">
            <input type="hidden" name="page" value="produits">
            <input type="text" name="recherche" placeholder="Rechercher un produit..." value="<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : ''; ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <!-- Navigation -->
        <nav class="nav-links" id="navLinks">
            <a href="index.php" class="<?php echo ($page == 'accueil') ? 'active' : ''; ?>">Accueil</a>
            <a href="index.php?page=produits" class="<?php echo ($page == 'produits') ? 'active' : ''; ?>">Produits</a>

            <!-- Menu deroulant categories -->
            <div class="nav-dropdown">
                <button type="button" class="dropdown-toggle" onclick="toggleDropdown(event)">
                    Catégories <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="catDropdown">
                    <?php if (!empty($categories_nav)): ?>
                        <?php foreach ($categories_nav as $cat_nav): ?>
                        <a href="index.php?page=produits&cat=<?php echo $cat_nav['slug']; ?>">
                            <?php echo htmlspecialchars($cat_nav['nom_categorie']); ?>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (isset($_SESSION['id_user'])): ?>
                <a href="index.php?page=commande" class="<?php echo ($page == 'commande') ? 'active' : ''; ?>">Mes Commandes</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="index.php?page=admin">Admin</a>
            <?php endif; ?>
        </nav>

        <!-- Icones droite -->
        <div class="nav-icons">
            <?php if (isset($_SESSION['id_user'])): ?>
                <!-- Nom utilisateur -->
                <span class="nav-user-greeting">
                    <i class="fas fa-user-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['nom_complet']); ?>
                </span>
                <!-- Panier -->
                <a href="index.php?page=panier" class="nav-icon-btn" title="Panier">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if (isset($nb_panier) && $nb_panier > 0): ?>
                        <span class="cart-badge"><?php echo $nb_panier; ?></span>
                    <?php endif; ?>
                </a>
                <!-- Deconnexion -->
                <a href="index.php?page=deconnexion" class="nav-icon-btn" title="Déconnexion">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            <?php else: ?>
                <a href="index.php?page=connexion" class="btn-connexion">
                    <i class="fas fa-user"></i> Connexion
                </a>
            <?php endif; ?>

            <!-- Menu burger mobile -->
            <span class="menu-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </span>
        </div>
    </div>
</header>
