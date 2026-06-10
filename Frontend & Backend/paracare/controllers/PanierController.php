<?php
// ===================================
// Controleur Panier
// Ajout, modification, suppression
// ===================================

// Verifier que l'utilisateur est connecte
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php?page=connexion');
    exit;
}

require_once 'models/Panier.php';
require_once 'models/Produit.php';

$panierModel = new Panier($connexion);
$produitModel = new Produit($connexion);

// Recuperer le panier de l'utilisateur
$monPanier = $panierModel->getPanier($_SESSION['id_user']);
$id_panier = $monPanier['id_panier'];

// ---- Ajouter au panier ----
if ($action == 'ajouter' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produit = intval($_POST['id_produit']);
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1;

    if ($id_produit > 0 && $quantite > 0) {
        $panierModel->ajouterArticle($id_panier, $id_produit, $quantite);
    }
    header('Location: index.php?page=panier');
    exit;
}

// ---- Modifier quantite ----
if ($action == 'modifier' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_item = intval($_POST['id_item']);
    $quantite = intval($_POST['quantite']);

    $panierModel->modifierQuantite($id_item, $quantite);
    header('Location: index.php?page=panier');
    exit;
}

// ---- Supprimer un article ----
if ($action == 'supprimer' && $id > 0) {
    $panierModel->supprimerArticle($id);
    header('Location: index.php?page=panier');
    exit;
}

// ---- Afficher le panier ----
$articles = $panierModel->getArticles($id_panier);
$total = $panierModel->getTotal($id_panier);
$economie_promo = $panierModel->getEconomiePromo($id_panier);
$nb_panier = $panierModel->compterArticles($id_panier);

require_once 'views/layouts/header.php';
require_once 'views/client/panier.php';
require_once 'views/layouts/footer.php';
?>
