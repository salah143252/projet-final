<?php
// ===================================
// Routeur principal - ParaCare
// Gere la navigation entre les pages
// ===================================

session_start();

// Charger la connexion et les helpers
require_once 'config/db.php';
require_once 'config/helpers.php';

// Recuperer la page demandee
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Categories pour le menu header (pages client)
$categories_nav = [];
if ($page != 'admin' && $page != 'newsletter') {
    require_once 'models/Categorie.php';
    $categorieNavModel = new Categorie($connexion);
    $categories_nav = $categorieNavModel->getTous();
}

// Routage vers les controleurs
switch ($page) {

    case 'accueil':
        require_once 'controllers/AccueilController.php';
        break;

    case 'produits':
        require_once 'controllers/ProduitController.php';
        break;

    case 'produit':
        require_once 'controllers/ProduitController.php';
        break;

    case 'panier':
        require_once 'controllers/PanierController.php';
        break;

    case 'commande':
        require_once 'controllers/CommandeController.php';
        break;

    case 'connexion':
        require_once 'controllers/AuthController.php';
        break;

    case 'inscription':
        require_once 'controllers/AuthController.php';
        break;

    case 'deconnexion':
        session_destroy();
        header('Location: index.php');
        exit;
        break;

    case 'admin':
        require_once 'controllers/AdminController.php';
        break;

    case 'newsletter':
        require_once 'controllers/NewsletterController.php';
        break;

    default:
        require_once 'controllers/AccueilController.php';
        break;
}
?>
