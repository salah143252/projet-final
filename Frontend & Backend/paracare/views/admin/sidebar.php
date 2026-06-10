<!-- Sidebar Admin - inclus dans toutes les pages admin -->
<button type="button" class="admin-menu-toggle" id="adminMenuToggle" onclick="toggleAdminSidebar()" aria-label="Ouvrir le menu">
    <i class="fas fa-bars"></i>
</button>
<div class="admin-sidebar-overlay" id="adminOverlay" onclick="toggleAdminSidebar()"></div>
<div class="admin-sidebar" id="adminSidebar">
    <div class="admin-logo">
        <h2>ParaCare</h2>
        <small>Administration</small>
    </div>
    <nav>
        <a href="index.php?page=admin&action=dashboard" class="<?php echo ($action == 'dashboard' || $action == '') ? 'active' : ''; ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="index.php?page=admin&action=produits" class="<?php echo ($action == 'produits' || $action == 'ajouter_produit' || $action == 'modifier_produit') ? 'active' : ''; ?>">
            <i class="fas fa-box"></i> Produits
        </a>
        <a href="index.php?page=admin&action=commandes" class="<?php echo ($action == 'commandes') ? 'active' : ''; ?>">
            <i class="fas fa-shopping-bag"></i> Commandes
        </a>
        <a href="index.php?page=admin&action=utilisateurs" class="<?php echo ($action == 'utilisateurs') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Utilisateurs
        </a>
        <a href="index.php?page=admin&action=statistiques" class="<?php echo ($action == 'statistiques') ? 'active' : ''; ?>">
            <i class="fas fa-chart-bar"></i> Statistiques
        </a>
        <a href="index.php" target="_blank">
            <i class="fas fa-external-link-alt"></i> Voir le site
        </a>
        <a href="index.php?page=deconnexion">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </nav>
</div>
<script src="assets/js/script.js"></script>
<script>
// Fermer le menu admin mobile apres navigation
document.querySelectorAll('#adminSidebar nav a').forEach(function(lien) {
    lien.addEventListener('click', function() {
        if (window.innerWidth <= 768) toggleAdminSidebar();
    });
});
</script>
