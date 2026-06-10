<!-- Page de confirmation de commande -->

<section class="section">
    <div class="succes-page">
        <i class="fas fa-check-circle"></i>
        <h2>Commande confirmée !</h2>
        <p>Merci pour votre commande. Votre numéro de commande est : <strong>#<?php echo $numero_commande; ?></strong></p>
        <p>Vous recevrez une confirmation par email prochainement.</p>
        <a href="index.php?page=commande" class="btn-lien">
            <i class="fas fa-list"></i> Voir mes commandes
        </a>
        <a href="index.php?page=produits" class="btn-lien" style="background:#27AE60; margin-left:10px;">
            <i class="fas fa-shopping-bag"></i> Continuer mes achats
        </a>
    </div>
</section>
