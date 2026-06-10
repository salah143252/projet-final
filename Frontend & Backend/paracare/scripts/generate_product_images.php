<?php
// Generateur d'images produits SVG pour ParaCare
// Cree des images SVG avec gradient et icone par produit

$dossier = __DIR__ . '/../assets/images/produits/';

// Definition des produits avec leurs couleurs et icones
$produits = [
    // Skincare (bleu/teal)
    'serum_antiage.svg' => [
        'couleur1' => '#E3F2FD', 'couleur2' => '#BBDEFB', 'accent' => '#2D9CDB',
        'icone' => 'serum', 'nom' => 'Serum Anti-age'
    ],
    // Haircare (violet/rose)
    'huile_capillaire.svg' => [
        'couleur1' => '#F3E5F5', 'couleur2' => '#E1BEE7', 'accent' => '#9C27B0',
        'icone' => 'huile', 'nom' => 'Huile Capillaire'
    ],
    'masque_cheveux.svg' => [
        'couleur1' => '#FCE4EC', 'couleur2' => '#F8BBD0', 'accent' => '#E91E63',
        'icone' => 'masque', 'nom' => 'Masque Cheveux'
    ],
    'shampooing_reparateur.svg' => [
        'couleur1' => '#EDE7F6', 'couleur2' => '#D1C4E9', 'accent' => '#673AB7',
        'icone' => 'shampooing', 'nom' => 'Shampooing Doux'
    ],
    // Body Care (vert)
    'lait_corporel.svg' => [
        'couleur1' => '#E8F5E9', 'couleur2' => '#C8E6C9', 'accent' => '#27AE60',
        'icone' => 'lait', 'nom' => 'Lait Corporel'
    ],
    'gel_douche.svg' => [
        'couleur1' => '#E0F7FA', 'couleur2' => '#B2EBF2', 'accent' => '#00ACC1',
        'icone' => 'gel', 'nom' => 'Gel Douche'
    ],
    'beurre_karite.svg' => [
        'couleur1' => '#FFF8E1', 'couleur2' => '#FFECB3', 'accent' => '#F9A825',
        'icone' => 'beurre', 'nom' => 'Beurre de Karite'
    ],
    'gommage_corps.svg' => [
        'couleur1' => '#F1F8E9', 'couleur2' => '#DCEDC8', 'accent' => '#689F38',
        'icone' => 'gommaage', 'nom' => 'Gommage Corps'
    ],
    // Vitamins (orange/jaune)
    'vitamine_c.svg' => [
        'couleur1' => '#FFF3E0', 'couleur2' => '#FFE0B2', 'accent' => '#FF9800',
        'icone' => 'vitamine', 'nom' => 'Vitamine C'
    ],
    'vitamine_d3.svg' => [
        'couleur1' => '#FFFDE7', 'couleur2' => '#FFF9C4', 'accent' => '#FBC02D',
        'icone' => 'vitamine_d3', 'nom' => 'Vitamine D3'
    ],
    'collagene_marin.svg' => [
        'couleur1' => '#E0F2F1', 'couleur2' => '#B2DFDB', 'accent' => '#00897B',
        'icone' => 'collagene', 'nom' => 'Collagene Marin'
    ],
    'omega3.svg' => [
        'couleur1' => '#E8EAF6', 'couleur2' => '#C5CAE9', 'accent' => '#3F51B5',
        'icone' => 'omega', 'nom' => 'Omega 3'
    ],
];

// Fonction pour generer l'icone SVG selon le type
function getIcone($type, $accent) {
    $blanc = '#FFFFFF';
    switch ($type) {
        case 'serum':
            // Flacon serum avec pipette
            return '
                <rect x="115" y="60" width="70" height="140" rx="12" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="130" y="45" width="40" height="25" rx="5" fill="' . $blanc . '" opacity="0.7"/>
                <rect x="145" y="25" width="10" height="25" rx="3" fill="' . $blanc . '" opacity="0.6"/>
                <circle cx="150" cy="130" r="20" fill="' . $accent . '" opacity="0.3"/>
                <text x="150" y="137" text-anchor="middle" fill="' . $accent . '" font-size="20" font-weight="bold">+</text>
            ';
        case 'huile':
            // Bouteille huile
            return '
                <rect x="120" y="70" width="60" height="130" rx="15" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="135" y="50" width="30" height="30" rx="4" fill="' . $blanc . '" opacity="0.7"/>
                <rect x="142" y="35" width="16" height="20" rx="4" fill="' . $blanc . '" opacity="0.6"/>
                <ellipse cx="150" cy="140" rx="18" ry="25" fill="' . $accent . '" opacity="0.25"/>
            ';
        case 'masque':
            // Pot masque
            return '
                <rect x="105" y="90" width="90" height="80" rx="15" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="100" y="80" width="100" height="20" rx="8" fill="' . $blanc . '" opacity="0.7"/>
                <ellipse cx="150" cy="130" rx="25" ry="15" fill="' . $accent . '" opacity="0.25"/>
            ';
        case 'shampooing':
            // Bouteille shampooing
            return '
                <rect x="118" y="65" width="64" height="135" rx="18" fill="' . $blanc . '" opacity="0.9"/>
                <path d="M135 65 L135 45 Q150 30 165 45 L165 65" fill="' . $blanc . '" opacity="0.7"/>
                <rect x="140" y="110" width="20" height="40" rx="5" fill="' . $accent . '" opacity="0.25"/>
            ';
        case 'lait':
            // Bouteille lait corporel
            return '
                <rect x="115" y="60" width="70" height="140" rx="20" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="130" y="42" width="40" height="25" rx="6" fill="' . $blanc . '" opacity="0.7"/>
                <circle cx="150" cy="130" r="22" fill="' . $accent . '" opacity="0.2"/>
                <path d="M140 125 Q150 115 160 125 Q155 135 150 140 Q145 135 140 125" fill="' . $accent . '" opacity="0.35"/>
            ';
        case 'gel':
            // Tube gel douche
            return '
                <rect x="120" y="55" width="60" height="145" rx="12" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="132" y="40" width="36" height="22" rx="6" fill="' . $blanc . '" opacity="0.7"/>
                <rect x="140" y="28" width="20" height="16" rx="4" fill="' . $blanc . '" opacity="0.5"/>
                <ellipse cx="150" cy="120" rx="15" ry="35" fill="' . $accent . '" opacity="0.2"/>
            ';
        case 'beurre':
            // Pot beurre karite
            return '
                <ellipse cx="150" cy="140" rx="50" ry="35" fill="' . $blanc . '" opacity="0.9"/>
                <ellipse cx="150" cy="115" rx="50" ry="12" fill="' . $blanc . '" opacity="0.7"/>
                <rect x="100" y="115" width="100" height="25" fill="' . $blanc . '" opacity="0.85"/>
                <ellipse cx="150" cy="135" rx="25" ry="12" fill="' . $accent . '" opacity="0.2"/>
            ';
        case 'gommaage':
            // Pot gommage
            return '
                <rect x="108" y="85" width="84" height="85" rx="18" fill="' . $blanc . '" opacity="0.9"/>
                <rect x="103" y="75" width="94" height="18" rx="7" fill="' . $blanc . '" opacity="0.7"/>
                <circle cx="135" cy="125" r="6" fill="' . $accent . '" opacity="0.3"/>
                <circle cx="155" cy="120" r="4" fill="' . $accent . '" opacity="0.25"/>
                <circle cx="145" cy="138" r="5" fill="' . $accent . '" opacity="0.2"/>
                <circle cx="165" cy="132" r="3" fill="' . $accent . '" opacity="0.3"/>
            ';
        case 'vitamine_d3':
            // Comprime vitamine D3
            return '
                <circle cx="150" cy="115" r="45" fill="' . $blanc . '" opacity="0.9"/>
                <circle cx="150" cy="115" r="30" fill="' . $accent . '" opacity="0.2"/>
                <text x="150" y="123" text-anchor="middle" fill="' . $accent . '" font-size="22" font-weight="bold" font-family="Arial">D3</text>
                <rect x="125" y="160" width="50" height="8" rx="4" fill="' . $blanc . '" opacity="0.5"/>
            ';
        case 'vitamine':
            // Comprime vitamine
            return '
                <circle cx="150" cy="115" r="45" fill="' . $blanc . '" opacity="0.9"/>
                <circle cx="150" cy="115" r="30" fill="' . $accent . '" opacity="0.2"/>
                <text x="150" y="123" text-anchor="middle" fill="' . $accent . '" font-size="28" font-weight="bold" font-family="Arial">C</text>
                <rect x="125" y="160" width="50" height="8" rx="4" fill="' . $blanc . '" opacity="0.5"/>
            ';
        case 'collagene':
            // Sachet collagene
            return '
                <rect x="110" y="55" width="80" height="120" rx="8" fill="' . $blanc . '" opacity="0.9"/>
                <path d="M110 55 L150 40 L190 55" fill="' . $blanc . '" opacity="0.7"/>
                <circle cx="150" cy="105" r="20" fill="' . $accent . '" opacity="0.2"/>
                <path d="M140 100 Q150 90 160 100 Q155 110 150 115 Q145 110 140 100" fill="' . $accent . '" opacity="0.35"/>
                <rect x="125" y="140" width="50" height="6" rx="3" fill="' . $accent . '" opacity="0.2"/>
                <rect x="130" y="150" width="40" height="5" rx="2" fill="' . $accent . '" opacity="0.15"/>
            ';
        case 'omega':
            // Capsule omega 3
            return '
                <ellipse cx="150" cy="110" rx="40" ry="25" fill="' . $blanc . '" opacity="0.9"/>
                <line x1="150" y1="85" x2="150" y2="135" stroke="' . $accent . '" stroke-width="1.5" opacity="0.3"/>
                <ellipse cx="135" cy="110" rx="15" ry="20" fill="' . $accent . '" opacity="0.15"/>
                <ellipse cx="165" cy="110" rx="15" ry="20" fill="' . $accent . '" opacity="0.25"/>
                <rect x="125" y="145" width="50" height="8" rx="4" fill="' . $blanc . '" opacity="0.5"/>
            ';
        default:
            return '
                <circle cx="150" cy="115" r="40" fill="' . $blanc . '" opacity="0.9"/>
                <text x="150" y="123" text-anchor="middle" fill="' . $accent . '" font-size="24" font-weight="bold">+</text>
            ';
    }
}

// Generer chaque SVG
foreach ($produits as $fichier => $config) {
    $id = 'grad_' . pathinfo($fichier, PATHINFO_FILENAME);
    $icone_svg = getIcone($config['icone'], $config['accent']);

    $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 250" width="300" height="250">
  <defs>
    <linearGradient id="' . $id . '" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:' . $config['couleur1'] . ';stop-opacity:1"/>
      <stop offset="100%" style="stop-color:' . $config['couleur2'] . ';stop-opacity:1"/>
    </linearGradient>
  </defs>
  <rect width="300" height="250" fill="url(#' . $id . ')" rx="8"/>
  ' . $icone_svg . '
  <text x="150" y="225" text-anchor="middle" fill="#555" font-size="13" font-weight="600" font-family="Poppins,Arial,sans-serif">' . $config['nom'] . '</text>
</svg>';

    file_put_contents($dossier . $fichier, $svg);
    echo "Cree : $fichier\n";
}

echo "\nToutes les images produits ont ete generees !\n";
