<?php
// ===================================
// Controleur Admin
// Dashboard, gestion produits, commandes, users, stats
// ===================================

// Verifier que c'est un admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php?page=connexion');
    exit;
}

require_once 'models/Produit.php';
require_once 'models/Categorie.php';
require_once 'models/Commande.php';
require_once 'models/Utilisateur.php';

$produitModel = new Produit($connexion);
$categorieModel = new Categorie($connexion);
$commandeModel = new Commande($connexion);
$userModel = new Utilisateur($connexion);

// ---- DASHBOARD ----
if ($action == 'dashboard' || $action == '') {
    $nb_clients = $userModel->compterClients();
    $nb_produits = $produitModel->compter();
    $nb_commandes = $commandeModel->compter();
    $chiffre_affaires = $commandeModel->getChiffreAffaires();
    $commandes_recentes = $commandeModel->getTous();
    // Limiter a 5
    $commandes_recentes = array_slice($commandes_recentes, 0, 5);
    // Donnees pour le graphique des ventes mensuelles
    $ventes_mensuelles = $commandeModel->getVentesMensuelles();
    // Top produits pour le dashboard
    $top_produits = $commandeModel->getTopProduits(5);
    // Commandes par statut (mini donut)
    $commandes_par_statut = $commandeModel->getParStatut();

    require_once 'views/admin/dashboard.php';
}

// ---- LISTE DES PRODUITS ----
elseif ($action == 'produits') {
    $produits = $produitModel->getTous(null, null, 1, 1000);
    $categories = $categorieModel->getTous();
    require_once 'views/admin/produits.php';
}

// ---- AJOUTER UN PRODUIT ----
elseif ($action == 'ajouter_produit') {
    $categories = $categorieModel->getTous();
    $erreur = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $prix = floatval($_POST['prix']);
        $stock = intval($_POST['stock']);
        $id_categorie = intval($_POST['id_categorie']);
        $image = 'default.svg';

        // Upload de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $extensions_ok = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array(strtolower($extension), $extensions_ok)) {
                $image = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/produits/' . $image);
            }
        }

        if (empty($nom) || empty($description) || $prix <= 0) {
            $erreur = "Veuillez remplir tous les champs correctement.";
        } else {
            $produitModel->ajouter($nom, $description, $prix, $stock, $image, $id_categorie);
            header('Location: index.php?page=admin&action=produits');
            exit;
        }
    }
    require_once 'views/admin/ajouter_produit.php';
}

// ---- MODIFIER UN PRODUIT ----
elseif ($action == 'modifier_produit' && $id > 0) {
    $produit = $produitModel->getParId($id);
    $categories = $categorieModel->getTous();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $prix = floatval($_POST['prix']);
        $stock = intval($_POST['stock']);
        $id_categorie = intval($_POST['id_categorie']);
        $image = $produit['image']; // Garder l'ancienne image par defaut

        // Nouvelle image?
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $extensions_ok = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array(strtolower($extension), $extensions_ok)) {
                $image = uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/produits/' . $image);
            }
        }

        $produitModel->modifier($id, $nom, $description, $prix, $stock, $image, $id_categorie);
        header('Location: index.php?page=admin&action=produits');
        exit;
    }
    require_once 'views/admin/modifier_produit.php';
}

// ---- SUPPRIMER UN PRODUIT ----
elseif ($action == 'supprimer_produit' && $id > 0) {
    $produitModel->supprimer($id);
    header('Location: index.php?page=admin&action=produits');
    exit;
}

// ---- COMMANDES ----
elseif ($action == 'commandes') {
    $commandes = $commandeModel->getTous();

    // Changer statut si formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_commande'])) {
        $commandeModel->changerStatut(intval($_POST['id_commande']), $_POST['nouveau_statut']);
        header('Location: index.php?page=admin&action=commandes');
        exit;
    }

    require_once 'views/admin/commandes.php';
}

// ---- UTILISATEURS ----
elseif ($action == 'utilisateurs') {
    $utilisateurs = $userModel->getTous();
    require_once 'views/admin/utilisateurs.php';
}

// ---- SUPPRIMER UTILISATEUR ----
elseif ($action == 'supprimer_user' && $id > 0) {
    $userModel->supprimer($id);
    header('Location: index.php?page=admin&action=utilisateurs');
    exit;
}

// ---- STATISTIQUES ----
elseif ($action == 'statistiques') {
    $nb_clients = $userModel->compterClients();
    $nb_produits = $produitModel->compter();
    $nb_commandes = $commandeModel->compter();
    $chiffre_affaires = $commandeModel->getChiffreAffaires();
    $ventes_mensuelles = $commandeModel->getVentesMensuelles();
    $commandes_par_statut = $commandeModel->getParStatut();
    $top_produits = $commandeModel->getTopProduits(5);

    require_once 'views/admin/statistiques.php';
}
?>
