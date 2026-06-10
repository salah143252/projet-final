<?php
// ===================================
// Fonctions utilitaires - ParaCare
// Prix promo, etoiles, images
// ===================================

// Verifier si un produit est en promotion (15% sur soins)
function aPromotion($produit) {
    $slug = isset($produit['cat_slug']) ? $produit['cat_slug'] : '';
    $slugs_promo = ['skincare', 'haircare', 'body-care'];
    if (in_array($slug, $slugs_promo)) {
        return ($produit['id_produit'] % 2 == 0);
    }
    return false;
}

// Calculer le prix apres reduction de 15%
function getPrixPromo($prix) {
    return round($prix * 0.85, 2);
}

// Prix reel a facturer (promo ou prix catalogue)
function getPrixEffectif($produit) {
    if (aPromotion($produit)) {
        return getPrixPromo($produit['prix']);
    }
    return floatval($produit['prix']);
}

// Expression SQL pour la note affichee (filtre catalogue)
function getNoteSqlCase($alias = 'p') {
    return "CASE {$alias}.id_produit
        WHEN 7 THEN 4.8 WHEN 8 THEN 4.9 WHEN 9 THEN 4.6 WHEN 10 THEN 4.5
        WHEN 11 THEN 4.7 WHEN 12 THEN 4.5 WHEN 13 THEN 4.2 WHEN 14 THEN 4.4
        WHEN 15 THEN 4.9 WHEN 16 THEN 4.6 WHEN 17 THEN 4.3 WHEN 18 THEN 4.0
        WHEN 19 THEN 4.8 WHEN 20 THEN 4.5 WHEN 21 THEN 4.7 WHEN 22 THEN 4.9
        WHEN 23 THEN 4.6 WHEN 24 THEN 4.4 WHEN 25 THEN 4.8 WHEN 26 THEN 4.5
        WHEN 27 THEN 4.7 WHEN 28 THEN 4.3 WHEN 29 THEN 4.6 WHEN 30 THEN 4.8
        ELSE 4.5 END";
}

// Note fixe par produit (pour affichage etoiles)
function getNoteProduit($id_produit) {
    $notes = [
        7 => 4.8, 8 => 4.9, 9 => 4.6, 10 => 4.5,
        11 => 4.7, 12 => 4.5, 13 => 4.2, 14 => 4.4,
        15 => 4.9, 16 => 4.6, 17 => 4.3, 18 => 4.0,
        19 => 4.8, 20 => 4.5, 21 => 4.7, 22 => 4.9,
        23 => 4.6, 24 => 4.4, 25 => 4.8, 26 => 4.5,
        27 => 4.7, 28 => 4.3, 29 => 4.6, 30 => 4.8,
    ];
    return isset($notes[$id_produit]) ? $notes[$id_produit] : 4.5;
}

// Generer le HTML des etoiles
function afficherEtoiles($note) {
    $html = '';
    $entier = floor($note);
    $demi = ($note - $entier) >= 0.5;

    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $entier) {
            $html .= '<i class="fas fa-star"></i>';
        } elseif ($i == $entier + 1 && $demi) {
            $html .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $html .= '<i class="far fa-star"></i>';
        }
    }
    return $html;
}

// Chemin image produit avec fallback
function imageProduit($image) {
    $chemin = 'assets/images/produits/' . $image;
    if (file_exists($chemin)) {
        return $chemin;
    }
    return 'assets/images/produits/default.svg';
}

// Image categorie pour les cercles accueil
function imageCategorie($slug) {
    $map = [
        'skincare' => 'cat_skincare.svg',
        'haircare' => 'cat_haircare.svg',
        'body-care' => 'cat_bodycare.svg',
        'vitamins' => 'cat_vitamins.svg'
    ];
    $fichier = isset($map[$slug]) ? $map[$slug] : 'cat_skincare.svg';
    return 'assets/images/categories/' . $fichier;
}
?>
