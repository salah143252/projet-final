<?php
// Generateur d'images categories SVG pour ParaCare

$dossier = __DIR__ . '/../assets/images/categories/';

$categories = [
    'cat_skincare.svg' => [
        'couleur1' => '#E3F2FD', 'couleur2' => '#BBDEFB', 'accent' => '#2D9CDB',
        'icone' => 'skincare', 'nom' => 'Skincare'
    ],
    'cat_haircare.svg' => [
        'couleur1' => '#F3E5F5', 'couleur2' => '#E1BEE7', 'accent' => '#9C27B0',
        'icone' => 'haircare', 'nom' => 'Haircare'
    ],
    'cat_bodycare.svg' => [
        'couleur1' => '#E8F5E9', 'couleur2' => '#C8E6C9', 'accent' => '#27AE60',
        'icone' => 'bodycare', 'nom' => 'Body Care'
    ],
    'cat_vitamins.svg' => [
        'couleur1' => '#FFF3E0', 'couleur2' => '#FFE0B2', 'accent' => '#FF9800',
        'icone' => 'vitamins', 'nom' => 'Vitamines'
    ],
];

function getIconeCat($type, $accent) {
    $blanc = '#FFFFFF';
    switch ($type) {
        case 'skincare':
            return '
                <circle cx="100" cy="90" r="35" fill="' . $blanc . '" opacity="0.9"/>
                <circle cx="100" cy="90" r="22" fill="' . $accent . '" opacity="0.2"/>
                <path d="M90 82 Q100 72 110 82 Q105 92 100 97 Q95 92 90 82" fill="' . $accent . '" opacity="0.4"/>
                <rect x="85" y="130" width="30" height="5" rx="2" fill="' . $blanc . '" opacity="0.5"/>
            ';
        case 'haircare':
            return '
                <rect x="85" y="55" width="30" height="70" rx="10" fill="' . $blanc . '" opacity="0.9"/>
                <path d="M92 55 L92 45 Q100 35 108 45 L108 55" fill="' . $blanc . '" opacity="0.7"/>
                <ellipse cx="100" cy="90" rx="10" ry="15" fill="' . $accent . '" opacity="0.2"/>
                <rect x="80" y="130" width="40" height="5" rx="2" fill="' . $blanc . '" opacity="0.5"/>
            ';
        case 'bodycare':
            return '
                <rect x="82" y="55" width="36" height="70" rx="14" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="88" y="42" width="24" height="18" rx="5" fill="' . $blanc . '" opacity="0.7"/>
                <circle cx="100" cy="90" r="12" fill="' . $accent . '" opacity="0.2"/>
                <path d="M94 86 Q100 78 106 86 Q103 93 100 96 Q97 93 94 86" fill="' . $accent . '" opacity="0.35"/>
                <rect x="80" y="130" width="40" height="5" rx="2" fill="' . $blanc . '" opacity="0.5"/>
            ';
        case 'vitamins':
            return '
                <circle cx="100" cy="85" r="30" fill="' . $blanc . '" opacity="0.9"/>
                <circle cx="100" cy="85" r="20" fill="' . $accent . '" opacity="0.2"/>
                <text x="100" y="92" text-anchor="middle" fill="' . $accent . '" font-size="22" font-weight="bold" font-family="Arial">V+</text>
                <rect x="80" y="125" width="40" height="5" rx="2" fill="' . $blanc . '" opacity="0.5"/>
            ';
        default:
            return '';
    }
}

foreach ($categories as $fichier => $config) {
    $id = 'cg_' . pathinfo($fichier, PATHINFO_FILENAME);
    $icone_svg = getIconeCat($config['icone'], $config['accent']);

    $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 170" width="200" height="170">
  <defs>
    <linearGradient id="' . $id . '" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:' . $config['couleur1'] . ';stop-opacity:1"/>
      <stop offset="100%" style="stop-color:' . $config['couleur2'] . ';stop-opacity:1"/>
    </linearGradient>
  </defs>
  <rect width="200" height="170" fill="url(#' . $id . ')" rx="12"/>
  ' . $icone_svg . '
  <text x="100" y="158" text-anchor="middle" fill="#555" font-size="12" font-weight="600" font-family="Poppins,Arial,sans-serif">' . $config['nom'] . '</text>
</svg>';

    file_put_contents($dossier . $fichier, $svg);
    echo "Cree : $fichier\n";
}

echo "\nCategorie images generees !\n";
