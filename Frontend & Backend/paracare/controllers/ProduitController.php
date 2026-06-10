<?php
// ===================================
// Controleur Produits
// Affichage catalogue et detail
// ===================================

require_once 'models/Produit.php';
require_once 'models/Categorie.php';

$produitModel = new Produit($connexion);
$categorieModel = new Categorie($connexion);

// Nombre d'articles dans le panier
$nb_panier = 0;
if (isset($_SESSION['id_user'])) {
    require_once 'models/Panier.php';
    $panierModel = new Panier($connexion);
    $monPanier = $panierModel->getPanier($_SESSION['id_user']);
    $nb_panier = $panierModel->compterArticles($monPanier['id_panier']);
}

// Page detail d'un produit
if ($page == 'produit' && $id > 0) {
    $produit = $produitModel->getParId($id);
    if (!$produit) {
        header('Location: index.php?page=produits');
        exit;
    }
    // Produits similaires
    $produits_similaires = $produitModel->getParCategorie($produit['id_categorie'], $produit['id_produit']);

    require_once 'views/layouts/header.php';
    require_once 'views/client/produit_detail.php';
    require_once 'views/layouts/footer.php';

} else {
    // Page catalogue
    $categorie_filtre = isset($_GET['cat']) ? $_GET['cat'] : null;
    $recherche = isset($_GET['recherche']) ? trim($_GET['recherche']) : null;
    $page_num = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
    $par_page = 8;

    // Filtre par prix
    $prix_filtre = isset($_GET['prix']) ? $_GET['prix'] : null;
    $prix_min = null;
    $prix_max = null;
    if ($prix_filtre == 'moins50') { $prix_max = 49.99; }
    elseif ($prix_filtre == '50-100') { $prix_min = 50; $prix_max = 100; }
    elseif ($prix_filtre == '100-200') { $prix_min = 100; $prix_max = 200; }
    elseif ($prix_filtre == 'plus200') { $prix_min = 200.01; }

    // Filtre par note (etoiles)
    $note_filtre = isset($_GET['note']) ? intval($_GET['note']) : null;
    $note_min = null;
    if (in_array($note_filtre, [3, 4, 5])) {
        $note_min = ($note_filtre == 5) ? 4.75 : (($note_filtre == 4) ? 4.0 : 3.0);
    }

    $total_produits = $produitModel->compterFiltres($categorie_filtre, $recherche, $prix_min, $prix_max, $note_min);
    $total_pages = max(1, ceil($total_produits / $par_page));
    if ($page_num > $total_pages) { $page_num = $total_pages; }

    $produits = $produitModel->getTous($categorie_filtre, $recherche, $page_num, $par_page, $prix_min, $prix_max, $note_min);
    $categories = $categorieModel->getTous();

    require_once 'views/layouts/header.php';
    require_once 'views/client/produits.php';
    require_once 'views/layouts/footer.php';
}
?>
