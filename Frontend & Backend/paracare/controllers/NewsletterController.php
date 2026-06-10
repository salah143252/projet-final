<?php
// ===================================
// Controleur Newsletter
// Inscription depuis le footer
// ===================================

require_once 'models/Newsletter.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$newsletterModel = new Newsletter($connexion);
$resultat = $newsletterModel->inscrire($email);

if ($resultat === 'ok') {
    echo json_encode(['success' => true, 'message' => 'Merci ! Vous êtes inscrit(e) à notre newsletter.']);
} elseif ($resultat === 'existe') {
    echo json_encode(['success' => true, 'message' => 'Cet email est déjà inscrit à notre newsletter.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Veuillez entrer une adresse email valide.']);
}
exit;
