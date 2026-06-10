<?php
// ===================================
// Controleur Commande
// Passer une commande / historique
// ===================================

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php?page=connexion');
    exit;
}

require_once 'models/Panier.php';
require_once 'models/Commande.php';
require_once 'models/Produit.php';

$panierModel = new Panier($connexion);
$commandeModel = new Commande($connexion);
$produitModel = new Produit($connexion);

// Nombre d'articles panier (pour le header)
$monPanier = $panierModel->getPanier($_SESSION['id_user']);
$nb_panier = $panierModel->compterArticles($monPanier['id_panier']);

// ---- Passer la commande ----
if ($action == 'passer' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse = trim($_POST['adresse_livraison']);
    $articles = $panierModel->getArticles($monPanier['id_panier']);
    $total = $panierModel->getTotal($monPanier['id_panier']);

    if (empty($adresse)) {
        $erreur = "Veuillez entrer une adresse de livraison.";
    } elseif (empty($articles)) {
        header('Location: index.php?page=panier');
        exit;
    } else {
        // Preparer les articles pour la commande
        $items = [];
        foreach ($articles as $art) {
            $items[] = [
                'id_produit' => $art['id_produit'],
                'quantite' => $art['quantite'],
                'prix' => getPrixEffectif($art)
            ];
            // Diminuer le stock
            $produitModel->diminuerStock($art['id_produit'], $art['quantite']);
        }

        // Creer la commande
        $id_commande = $commandeModel->creer($_SESSION['id_user'], $adresse, $total, $items);

        if ($id_commande) {
            // Vider le panier
            $panierModel->vider($monPanier['id_panier']);
            $nb_panier = 0;
            $succes_commande = true;
            $numero_commande = $id_commande;
            require_once 'views/layouts/header.php';
            require_once 'views/client/commande_succes.php';
            require_once 'views/layouts/footer.php';
            exit;
        }
    }
}

// ---- Page de commande (checkout) ----
if ($action == 'checkout') {
    $articles = $panierModel->getArticles($monPanier['id_panier']);
    $total = $panierModel->getTotal($monPanier['id_panier']);

    if (empty($articles)) {
        header('Location: index.php?page=panier');
        exit;
    }

    require_once 'views/layouts/header.php';
    require_once 'views/client/checkout.php';
    require_once 'views/layouts/footer.php';
    exit;
}

// ---- Historique des commandes ----
$commandes = $commandeModel->getParUtilisateur($_SESSION['id_user']);
require_once 'views/layouts/header.php';
require_once 'views/client/mes_commandes.php';
require_once 'views/layouts/footer.php';
?>
