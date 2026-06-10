<?php
// ===================================
// Controleur page d'accueil
// ===================================

require_once 'models/Produit.php';
require_once 'models/Categorie.php';

$produitModel = new Produit($connexion);
$categorieModel = new Categorie($connexion);

// Recuperer les donnees pour la page d'accueil
$produits_recents = $produitModel->getRecents(8);
$categories = $categorieModel->getTous();

// Statistiques hero (donnees reelles + affichage marketing)
$stats_hero = [
    'produits' => $produitModel->compter(),
    'categories' => count($categories),
    'clients' => '10k+',
    'satisfaction' => '98%'
];

// Nombre d'articles dans le panier (pour le header)
$nb_panier = 0;
if (isset($_SESSION['id_user'])) {
    require_once 'models/Panier.php';
    $panierModel = new Panier($connexion);
    $monPanier = $panierModel->getPanier($_SESSION['id_user']);
    $nb_panier = $panierModel->compterArticles($monPanier['id_panier']);
}

// Afficher la page
require_once 'views/layouts/header.php';
require_once 'views/client/accueil.php';
require_once 'views/layouts/footer.php';
?>
