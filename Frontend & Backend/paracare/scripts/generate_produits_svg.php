<?php
// Script one-shot : genere les images SVG produits
$produits = [
    ['fichier' => 'creme_hydratante.svg', 'nom' => 'CREME', 'sous' => 'Hydratante', 'couleur1' => '#e3f2fd', 'couleur2' => '#2D9CDB', 'type' => 'tube'],
    ['fichier' => 'serum_antiage.svg', 'nom' => 'SERUM', 'sous' => 'Anti-age', 'couleur1' => '#f3e5f5', 'couleur2' => '#9b59b6', 'type' => 'flacon'],
    ['fichier' => 'nettoyant_visage.svg', 'nom' => 'NETTOYANT', 'sous' => 'Visage', 'couleur1' => '#e0f7fa', 'couleur2' => '#00acc1', 'type' => 'pompe'],
    ['fichier' => 'shampooing_reparateur.svg', 'nom' => 'SHAMPOO', 'sous' => 'Reparateur', 'couleur1' => '#e8f5e9', 'couleur2' => '#27AE60', 'type' => 'bouteille'],
    ['fichier' => 'beurre_karite.svg', 'nom' => 'BEURRE', 'sous' => 'Karite', 'couleur1' => '#fff8e1', 'couleur2' => '#f39c12', 'type' => 'pot'],
    ['fichier' => 'gel_douche.svg', 'nom' => 'GEL', 'sous' => 'Douche', 'couleur1' => '#e8eaf6', 'couleur2' => '#5c6bc0', 'type' => 'bouteille'],
    ['fichier' => 'vitamine_c.svg', 'nom' => 'VITAMINE C', 'sous' => '1000mg', 'couleur1' => '#fff3e0', 'couleur2' => '#ff9800', 'type' => 'boite'],
    ['fichier' => 'vitamine_d3.svg', 'nom' => 'VITAMINE D3', 'sous' => '2000 UI', 'couleur1' => '#fce4ec', 'couleur2' => '#e91e63', 'type' => 'boite'],
    ['fichier' => 'omega3.svg', 'nom' => 'OMEGA 3', 'sous' => 'Fish Oil', 'couleur1' => '#e3f2fd', 'couleur2' => '#1976d2', 'type' => 'boite'],
    ['fichier' => 'collagene_marin.svg', 'nom' => 'COLLAGENE', 'sous' => 'Marin', 'couleur1' => '#e0f2f1', 'couleur2' => '#00897b', 'type' => 'boite'],
];

$dir = dirname(__DIR__) . '/assets/images/produits/';

foreach ($produits as $p) {
    $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
  <rect width="400" height="400" fill="' . $p['couleur1'] . '" rx="12"/>
  <rect x="130" y="100" width="140" height="180" rx="18" fill="' . $p['couleur2'] . '" opacity="0.75"/>
  <rect x="145" y="75" width="110" height="35" rx="10" fill="' . $p['couleur2'] . '"/>
  <rect x="155" y="140" width="90" height="90" rx="8" fill="#fff" opacity="0.92"/>
  <text x="200" y="175" text-anchor="middle" font-family="Arial,sans-serif" font-size="13" font-weight="700" fill="' . $p['couleur2'] . '">' . $p['nom'] . '</text>
  <text x="200" y="198" text-anchor="middle" font-family="Arial,sans-serif" font-size="11" fill="#666">' . $p['sous'] . '</text>
  <text x="200" y="350" text-anchor="middle" font-family="Poppins,Arial" font-size="12" fill="#999">ParaCare</text>
</svg>';
    file_put_contents($dir . $p['fichier'], $svg);
    echo "OK: " . $p['fichier'] . "\n";
}
echo "Termine.\n";
