<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - ParaCare Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Chart.js pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <?php require_once 'views/admin/sidebar.php'; ?>

    <!-- Contenu principal -->
    <div class="admin-content">
        <div class="admin-header">
            <h1>Statistiques</h1>
        </div>

        <!-- Cartes resume avec indicateurs de tendance -->
        <div class="stats-grid">
            <div class="stat-card stat-card-blue">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Clients</p>
                        <h3><?php echo $nb_clients; ?></h3>
                    </div>
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <p class="stat-trend trend-green"><i class="fas fa-arrow-up"></i> Base clientèle active</p>
            </div>
            <div class="stat-card stat-card-green">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Produits</p>
                        <h3><?php echo $nb_produits; ?></h3>
                    </div>
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <p class="stat-trend trend-green"><i class="fas fa-check-circle"></i> Catalogue complet</p>
            </div>
            <div class="stat-card stat-card-orange">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Commandes</p>
                        <h3><?php echo $nb_commandes; ?></h3>
                    </div>
                    <div class="stat-icon stat-icon-orange">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <p class="stat-trend trend-orange"><i class="fas fa-clock"></i> Toutes périodes</p>
            </div>
            <div class="stat-card stat-card-purple">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Chiffre d'affaires</p>
                        <h3 style="font-size:20px;"><?php echo number_format($chiffre_affaires, 0, ',', ' '); ?> DH</h3>
                    </div>
                    <div class="stat-icon stat-icon-purple">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
                <p class="stat-trend trend-green"><i class="fas fa-arrow-up"></i> Hors annulées</p>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="charts-grid">
            <!-- Graphique des ventes mensuelles -->
            <div class="chart-card">
                <h3><i class="fas fa-chart-line"></i> Ventes mensuelles</h3>
                <canvas id="chartVentes"></canvas>
            </div>

            <!-- Objectif mensuel gauge + statut commandes -->
            <div class="chart-card">
                <h3><i class="fas fa-bullseye"></i> Objectif mensuel</h3>
                <?php
                // Calculer objectif : 20% du CA total en mensuel
                $objectif_mensuel = max(5000, $chiffre_affaires * 0.15);
                $ca_dernier_mois = 0;
                if (!empty($ventes_mensuelles)) {
                    $ca_dernier_mois = floatval($ventes_mensuelles[0]['total_ventes']);
                }
                $pct_objectif = ($objectif_mensuel > 0) ? min(100, round(($ca_dernier_mois / $objectif_mensuel) * 100)) : 0;
                ?>
                <div style="text-align:center; margin-bottom:10px;">
                    <canvas id="chartObjectif" style="max-width:200px; max-height:200px; margin:0 auto;"></canvas>
                    <p style="font-size:22px; font-weight:700; color:#2D9CDB; margin:10px 0 5px;"><?php echo $pct_objectif; ?>%</p>
                    <p style="font-size:13px; color:#888;">Objectif: <?php echo number_format($objectif_mensuel, 0, ',', ' '); ?> DH/mois</p>
                </div>
                <h3 style="margin-top:20px;"><i class="fas fa-chart-pie"></i> Statut commandes</h3>
                <canvas id="chartStatut" style="max-height:200px;"></canvas>
            </div>
        </div>

        <!-- Top produits -->
        <div class="chart-card" style="margin-top: 25px;">
            <h3><i class="fas fa-trophy"></i> Top 5 produits les plus vendus</h3>
            <?php if (empty($top_produits)): ?>
                <p style="color:#888; text-align:center; padding:20px;">Aucune vente pour le moment.</p>
            <?php else: ?>
                <canvas id="chartProduits" style="max-height: 300px;"></canvas>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Script pour les graphiques Chart.js -->
<script>
// --- Graphique Ventes mensuelles (courbe) ---
<?php
// Preparer les donnees pour le graphique
$mois_labels = [];
$mois_ventes = [];
$mois_nb = [];

if (!empty($ventes_mensuelles)) {
    // Inverser pour avoir du plus ancien au plus recent
    $ventes_inv = array_reverse($ventes_mensuelles);
    foreach ($ventes_inv as $v) {
        $mois_labels[] = $v['mois'];
        $mois_ventes[] = $v['total_ventes'];
        $mois_nb[] = $v['nb_commandes'];
    }
}
?>

// --- Graphique Objectif mensuel (gauge doughnut) ---
var ctxObj = document.getElementById('chartObjectif').getContext('2d');
new Chart(ctxObj, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [<?php echo $pct_objectif; ?>, <?php echo 100 - $pct_objectif; ?>],
            backgroundColor: ['#2D9CDB', '#eef2f7'],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '75%',
        plugins: { legend: { display: false }, tooltip: { enabled: false } }
    }
});

// --- Graphique Ventes mensuelles (courbe) ---
var ctxVentes = document.getElementById('chartVentes').getContext('2d');
new Chart(ctxVentes, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($mois_labels); ?>,
        datasets: [{
            label: 'Ventes (DH)',
            data: <?php echo json_encode($mois_ventes); ?>,
            borderColor: '#2D9CDB',
            backgroundColor: 'rgba(45, 156, 219, 0.1)',
            tension: 0.3,
            fill: true
        }, {
            label: 'Nombre de commandes',
            data: <?php echo json_encode($mois_nb); ?>,
            borderColor: '#27AE60',
            backgroundColor: 'rgba(39, 174, 96, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// --- Graphique Commandes par statut (doughnut) ---
<?php
$statut_labels = [];
$statut_nombres = [];
$statut_colors = [];

if (!empty($commandes_par_statut)) {
    foreach ($commandes_par_statut as $s) {
        $statut_labels[] = ucfirst(str_replace('_', ' ', $s['statut']));
        $statut_nombres[] = $s['nombre'];
        // Couleur selon le statut
        if ($s['statut'] == 'en_attente') $statut_colors[] = '#f39c12';
        elseif ($s['statut'] == 'confirmee') $statut_colors[] = '#27AE60';
        elseif ($s['statut'] == 'livree') $statut_colors[] = '#2D9CDB';
        elseif ($s['statut'] == 'annulee') $statut_colors[] = '#e74c3c';
        else $statut_colors[] = '#95a5a6';
    }
}
?>

var ctxStatut = document.getElementById('chartStatut').getContext('2d');
new Chart(ctxStatut, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($statut_labels); ?>,
        datasets: [{
            data: <?php echo json_encode($statut_nombres); ?>,
            backgroundColor: <?php echo json_encode($statut_colors); ?>
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// --- Graphique Top produits (barres) ---
<?php
$prod_labels = [];
$prod_vendus = [];

if (!empty($top_produits)) {
    foreach ($top_produits as $p) {
        $prod_labels[] = $p['nom'];
        $prod_vendus[] = $p['total_vendu'];
    }
}
?>

var ctxProduits = document.getElementById('chartProduits');
if (ctxProduits) {
    new Chart(ctxProduits.getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($prod_labels); ?>,
            datasets: [{
                label: 'Quantité vendue',
                data: <?php echo json_encode($prod_vendus); ?>,
                backgroundColor: [
                    '#2D9CDB',
                    '#27AE60',
                    '#f39c12',
                    '#e74c3c',
                    '#9b59b6'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}
</script>

</body>
</html>
