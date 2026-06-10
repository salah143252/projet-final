<?php
/**
 * Télécharge des photos réelles pour les produits ParaCare
 * et met à jour / ajoute des produits en base de données.
 *
 * Usage : php scripts/setup_product_photos.php
 */

require_once __DIR__ . '/../config/db.php';

$imagesDir = __DIR__ . '/../assets/images/produits/';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

// Mise à jour des produits existants (id => [fichier, url])
$updates = [
    10 => ['serum_antiage.jpg', 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=600&h=600&fit=crop&q=80'],
    12 => ['huile_capillaire.jpg', 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=600&h=600&fit=crop&q=80'],
    13 => ['masque_cheveux.jpg', 'https://images.pexels.com/photos/4465124/pexels-photo-4465124.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop'],
    14 => ['shampooing_doux.jpg', 'https://images.unsplash.com/photo-1571875257727-256c39da42af?w=600&h=600&fit=crop&q=80'],
    15 => ['lait_corporel.jpg', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&h=600&fit=crop&q=80'],
    16 => ['gel_douche.jpg', 'https://images.unsplash.com/photo-1625772452859-1c03d5bf1137?w=600&h=600&fit=crop&q=80'],
    17 => ['beurre_karite.jpg', 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=600&h=600&fit=crop&q=80'],
    18 => ['gommage_corps.jpg', 'https://images.pexels.com/photos/4041392/pexels-photo-4041392.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop'],
    19 => ['vitamine_c.jpg', 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=600&h=600&fit=crop&q=80'],
    20 => ['vitamine_d3.jpg', 'https://images.pexels.com/photos/3683100/pexels-photo-3683100.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop'],
    21 => ['collagene_marin.jpg', 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=600&h=600&fit=crop&q=80'],
    22 => ['omega3.jpg', 'https://images.pexels.com/photos/3683080/pexels-photo-3683080.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop'],
];

// Nouveaux produits à ajouter
$nouveaux = [
    [
        'nom' => 'Après-Shampooing Démêlant',
        'description' => 'Après-shampooing enrichi en kératine et huile d\'argan pour des cheveux soyeux, faciles à coiffer et sans nœuds. Formule sans silicone.',
        'prix' => 69.90,
        'stock' => 45,
        'id_categorie' => 2,
        'image' => 'apres_shampooing.jpg',
        'url' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=600&h=600&fit=crop&q=80',
    ],
    [
        'nom' => 'Spray Protecteur Chaleur',
        'description' => 'Spray thermo-protecteur jusqu\'à 230°C. Protège les cheveux du sèche-cheveux et du lisseur tout en apportant brillance et souplesse.',
        'prix' => 54.90,
        'stock' => 60,
        'id_categorie' => 2,
        'image' => 'spray_protecteur.jpg',
        'url' => 'https://images.pexels.com/photos/3992206/pexels-photo-3992206.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop',
    ],
    [
        'nom' => 'Crème Solaire SPF50+',
        'description' => 'Crème solaire visage haute protection SPF50+. Texture légère, non grasse, résistante à l\'eau. Convient aux peaux sensibles.',
        'prix' => 129.90,
        'stock' => 35,
        'id_categorie' => 1,
        'image' => 'creme_solaire.jpg',
        'url' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=600&h=600&fit=crop&q=80',
    ],
    [
        'nom' => 'Crème Contour des Yeux',
        'description' => 'Soin ciblé anti-cernes et anti-poches à la caféine et au collagène. Texture fraîche pour un regard reposé et lumineux.',
        'prix' => 89.90,
        'stock' => 40,
        'id_categorie' => 1,
        'image' => 'creme_yeux.jpg',
        'url' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?w=600&h=600&fit=crop&q=80',
    ],
    [
        'nom' => 'Crème Mains Réparatrice',
        'description' => 'Crème mains ultra-nourrissante à l\'urée et au beurre de karité. Répare les mains sèches et abîmées, absorption rapide.',
        'prix' => 39.90,
        'stock' => 80,
        'id_categorie' => 3,
        'image' => 'creme_mains.jpg',
        'url' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=600&h=600&fit=crop&q=80',
    ],
    [
        'nom' => 'Déodorant Naturel Roll-On',
        'description' => 'Déodorant roll-on 24h à l\'aloe vera et au citron. Sans aluminium, sans alcool. Efficacité longue durée et fraîcheur naturelle.',
        'prix' => 49.90,
        'stock' => 55,
        'id_categorie' => 3,
        'image' => 'deodorant_naturel.jpg',
        'url' => 'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600&h=600&fit=crop&q=80',
    ],
    [
        'nom' => 'Multivitamines Quotidiennes',
        'description' => 'Complexe multivitaminé complet (A, B, C, D, E) pour soutenir l\'énergie, l\'immunité et le bien-être au quotidien. 60 comprimés.',
        'prix' => 119.90,
        'stock' => 70,
        'id_categorie' => 4,
        'image' => 'multivitamines.jpg',
        'url' => 'https://images.pexels.com/photos/3683081/pexels-photo-3683081.jpeg?auto=compress&cs=tinysrgb&w=600&h=600&fit=crop',
    ],
    [
        'nom' => 'Zinc + Magnésium',
        'description' => 'Complément alimentaire zinc et magnésium pour renforcer le système immunitaire, réduire la fatigue et soutenir les fonctions musculaires.',
        'prix' => 79.90,
        'stock' => 50,
        'id_categorie' => 4,
        'image' => 'zinc_magnesium.jpg',
        'url' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=600&h=600&fit=crop&q=80',
    ],
];

function telechargerImage($url, $destination) {
    $ctx = stream_context_create([
        'http' => [
            'timeout' => 30,
            'user_agent' => 'ParaCare-Setup/1.0',
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);

    $data = @file_get_contents($url, false, $ctx);
    if ($data === false || strlen($data) < 1000) {
        return false;
    }
    return file_put_contents($destination, $data) !== false;
}

echo "=== ParaCare - Installation des photos produits ===\n\n";

// Mise à jour des produits existants
$stmtUpdate = $connexion->prepare('UPDATE produits SET image = :img WHERE id_produit = :id');

foreach ($updates as $id => [$fichier, $url]) {
    $dest = $imagesDir . $fichier;
    echo "Produit #$id → $fichier ... ";

    if (!file_exists($dest)) {
        if (!telechargerImage($url, $dest)) {
            echo "ÉCHEC téléchargement\n";
            continue;
        }
    }

    $stmtUpdate->execute([':img' => $fichier, ':id' => $id]);
    echo "OK\n";
}

// Ajout des nouveaux produits
$stmtInsert = $connexion->prepare(
    'INSERT INTO produits (nom, description, prix, stock, image, id_categorie)
     VALUES (:nom, :desc, :prix, :stock, :img, :cat)'
);

$stmtCheck = $connexion->prepare('SELECT COUNT(*) FROM produits WHERE nom = :nom');

foreach ($nouveaux as $prod) {
    $stmtCheck->execute([':nom' => $prod['nom']]);
    if ($stmtCheck->fetchColumn() > 0) {
        echo "Produit déjà existant : {$prod['nom']}\n";
        continue;
    }

    $dest = $imagesDir . $prod['image'];
    echo "Nouveau : {$prod['nom']} → {$prod['image']} ... ";

    if (!file_exists($dest)) {
        if (!telechargerImage($prod['url'], $dest)) {
            echo "ÉCHEC téléchargement\n";
            continue;
        }
    }

    $stmtInsert->execute([
        ':nom' => $prod['nom'],
        ':desc' => $prod['description'],
        ':prix' => $prod['prix'],
        ':stock' => $prod['stock'],
        ':img' => $prod['image'],
        ':cat' => $prod['id_categorie'],
    ]);
    echo "OK (id=" . $connexion->lastInsertId() . ")\n";
}

echo "\n=== Terminé ! ===\n";
