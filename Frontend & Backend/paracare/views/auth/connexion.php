<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ParaCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background:#F2F5F9; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:20px;">

<div class="auth-card">
    <!-- Logo & titre -->
    <div class="auth-logo">
        <img src="assets/images/logo.svg" alt="ParaCare" style="height:48px; width:auto;">
        <span>ParaCare</span>
    </div>

    <h2 class="auth-title">Bon retour !</h2>
    <p class="auth-subtitle">Connectez-vous à votre compte pour continuer.</p>

    <!-- Message d'erreur -->
    <?php if (!empty($erreur)): ?>
        <div class="alert alert-erreur"><i class="fas fa-exclamation-circle"></i> <?php echo $erreur; ?></div>
    <?php endif; ?>

    <!-- Message de succes -->
    <?php if (!empty($succes)): ?>
        <div class="alert alert-succes"><i class="fas fa-check-circle"></i> <?php echo $succes; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=connexion">
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope" style="color:#2D9CDB; margin-right:5px;"></i> Adresse email</label>
            <input type="email" name="email" id="email" placeholder="exemple@paracare.com" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="motdepasse"><i class="fas fa-lock" style="color:#2D9CDB; margin-right:5px;"></i> Mot de passe</label>
            <input type="password" name="motdepasse" id="motdepasse" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-sign-in-alt"></i> Se connecter
        </button>
    </form>

    <div class="auth-divider"><span>ou</span></div>

    <p class="form-link">
        Pas encore de compte ? <a href="index.php?page=inscription">Créer un compte</a>
    </p>
    <p class="form-link" style="margin-top:10px;">
        <a href="index.php" style="color:#888; font-size:13px;">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
    </p>
</div>

</body>
</html>
