<?php
// ===================================
// Controleur Authentification
// Connexion et Inscription
// ===================================

require_once 'models/Utilisateur.php';

$userModel = new Utilisateur($connexion);
$erreur = '';
$succes = '';

// ---- Traitement Connexion ----
if ($page == 'connexion') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $motdepasse = $_POST['motdepasse'];

        if (empty($email) || empty($motdepasse)) {
            $erreur = "Veuillez remplir tous les champs.";
        } else {
            $user = $userModel->connecter($email, $motdepasse);
            if ($user) {
                // Stocker les infos en session
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['nom_complet'] = $user['prenom'] . ' ' . $user['nom'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Rediriger selon le role
                if ($user['role'] == 'admin') {
                    header('Location: index.php?page=admin&action=dashboard');
                } else {
                    header('Location: index.php?page=accueil');
                }
                exit;
            } else {
                $erreur = "Email ou mot de passe incorrect.";
            }
        }
    }

    require_once 'views/auth/connexion.php';
}

// ---- Traitement Inscription ----
if ($page == 'inscription') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $motdepasse = $_POST['motdepasse'];
        $telephone = trim($_POST['telephone']);
        $adresse = trim($_POST['adresse']);

        // Validation
        if (empty($nom) || empty($prenom) || empty($email) || empty($motdepasse)) {
            $erreur = "Veuillez remplir les champs obligatoires.";
        } elseif (strlen($motdepasse) < 6) {
            $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
        } elseif ($userModel->emailExiste($email)) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Creer le compte
            $userModel->inscrire($nom, $prenom, $email, $motdepasse, $telephone, $adresse);
            $succes = "Compte créé avec succès ! Vous pouvez vous connecter.";
            // Rediriger vers la connexion
            require_once 'views/auth/connexion.php';
            exit;
        }
    }

    require_once 'views/auth/inscription.php';
}
?>
