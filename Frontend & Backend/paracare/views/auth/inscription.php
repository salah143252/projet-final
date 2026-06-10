<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - ParaCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background:#F2F5F9; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px;">

<div class="auth-card" style="max-width:520px;">
    <!-- Logo & titre -->
    <div class="auth-logo">
        <img src="assets/images/logo.svg" alt="ParaCare" style="height:48px; width:auto;">
        <span>ParaCare</span>
    </div>

    <h2 class="auth-title">Créer un compte</h2>
    <p class="auth-subtitle">Rejoignez ParaCare pour profiter de nos offres exclusives.</p>

    <!-- Message d'erreur -->
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-erreur"><i class="fas fa-exclamation-circle"></i> <?php echo $erreur; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=inscription">
        <!-- Nom et Prenom cote a cote -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
            <div class="form-group">
                <label for="nom"><i class="fas fa-user" style="color:#2D9CDB; margin-right:5px;"></i> Nom *</label>
                <input type="text" name="nom" id="nom" placeholder="Votre nom" required
                       value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" required
                       value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="email"><i class="fas fa-envelope" style="color:#2D9CDB; margin-right:5px;"></i> Adresse email *</label>
            <input type="email" name="email" id="email" placeholder="exemple@paracare.com" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="motdepasse"><i class="fas fa-lock" style="color:#2D9CDB; margin-right:5px;"></i> Mot de passe * <small style="color:#aaa;">(min. 6 caractères)</small></label>
            <input type="password" name="motdepasse" id="motdepasse" placeholder="••••••••" minlength="6" required>
        </div>

        <div class="form-group">
            <label for="telephone"><i class="fas fa-phone" style="color:#2D9CDB; margin-right:5px;"></i> Téléphone</label>
            <input type="tel" name="telephone" id="telephone" placeholder="+212 6 00 00 00 00"
                   value="<?php echo isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="adresse"><i class="fas fa-map-marker-alt" style="color:#2D9CDB; margin-right:5px;"></i> Adresse</label>
            <textarea name="adresse" id="adresse" placeholder="Votre adresse de livraison..."><?php echo isset($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : ''; ?></textarea>
        </div>

        <button type="submit" class="btn-submit" style="background:#27AE60;">
            <i class="fas fa-user-plus"></i> Créer mon compte
        </button>
    </form>

    <div class="auth-divider"><span>ou</span></div>

    <p class="form-link">
        Déjà inscrit ? <a href="index.php?page=connexion">Se connecter</a>
    </p>
    <p class="form-link" style="margin-top:10px;">
        <a href="index.php" style="color:#888; font-size:13px;">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
    </p>
</div>

</body>
</html>
