<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - ParaCare</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <?php require_once 'views/admin/sidebar.php'; ?>

    <!-- Contenu principal -->
    <div class="admin-content">
        <!-- En-tete dashboard -->
        <div class="admin-header">
            <div>
                <h1>Dashboard</h1>
                <p style="color:#888; font-size:13px; margin-top:3px;">
                    <i class="fas fa-calendar-alt"></i> <?php echo date('d F Y'); ?>
                </p>
            </div>
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="font-size:14px; color:#666;">
                    <i class="fas fa-user-circle" style="color:#2D9CDB;"></i>
                    <?php echo htmlspecialchars($_SESSION['nom_complet']); ?>
                </span>
                <a href="index.php" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-external-link-alt"></i> Voir le site
                </a>
            </div>
        </div>

        <!-- Cartes statistiques avec indicateurs tendance -->
        <div class="stats-grid">
            <div class="stat-card stat-card-blue">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Clients inscrits</p>
                        <h3><?php echo $nb_clients; ?></h3>
                    </div>
                    <div class="stat-icon stat-icon-blue">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <p class="stat-trend trend-green">
                    <i class="fas fa-arrow-up"></i> Actifs sur le site
                </p>
            </div>

            <div class="stat-card stat-card-green">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Produits catalogue</p>
                        <h3><?php echo $nb_produits; ?></h3>
                    </div>
                    <div class="stat-icon stat-icon-green">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <p class="stat-trend trend-green">
                    <i class="fas fa-check-circle"></i> En stock disponible
                </p>
            </div>

            <div class="stat-card stat-card-orange">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <p style="font-size:13px; color:#888; margin-bottom:5px;">Total commandes</p>
                        <h3><?php echo $nb_commandes; ?></h3>
                    </div>
                    <div class="stat-icon stat-icon-orange">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <p class="stat-trend trend-orange">
                    <i class="fas fa-clock"></i> Toutes périodes
                </p>
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
                <p class="stat-trend trend-green">
                    <i class="fas fa-arrow-up"></i> Hors commandes annulées
                </p>
            </div>
        </div>

        <!-- Graphiques : 2 colonnes -->
        <div class="dashboard-charts">
            <!-- Graphique ventes mensuelles -->
            <div class="chart-card chart-card-wide">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h3><i class="fas fa-chart-line" style="color:#2D9CDB;"></i> Évolution des ventes</h3>
                    <a href="index.php?page=admin&action=statistiques" class="btn btn-primary btn-sm">
                        <i class="fas fa-chart-bar"></i> Statistiques
                    </a>
                </div>
                <?php if (empty($ventes_mensuelles)): ?>
                    <div class="chart-empty">
                        <i class="fas fa-chart-line"></i>
                        <p>Aucune donnée de vente pour le moment.</p>
                    </div>
                <?php else: ?>
                    <canvas id="chartVentesDashboard" style="max-height:260px;"></canvas>
                <?php endif; ?>
            </div>

            <!-- Donut statut commandes -->
            <div class="chart-card chart-card-narrow">
                <h3><i class="fas fa-chart-pie" style="color:#9b59b6;"></i> Statut commandes</h3>
                <?php if (empty($commandes_par_statut)): ?>
                    <div class="chart-empty">
                        <i class="fas fa-chart-pie"></i>
                        <p>Aucune commande.</p>
                    </div>
                <?php else: ?>
                    <canvas id="chartStatutDashboard" style="max-height:200px; max-width:200px; margin:0 auto;"></canvas>
                    <div class="statut-legend">
                        <?php
                        $statut_couleurs = [
                            'en_attente' => ['#f39c12', 'En attente'],
                            'confirmee' => ['#27AE60', 'Confirmée'],
                            'livree' => ['#2D9CDB', 'Livrée'],
                            'annulee' => ['#e74c3c', 'Annulée']
                        ];
                        foreach ($commandes_par_statut as $s):
                            $info = $statut_couleurs[$s['statut']] ?? ['#95a5a6', $s['statut']];
                        ?>
                        <div class="statut-legend-item">
                            <span class="statut-dot" style="background:<?php echo $info[0]; ?>;"></span>
                            <span><?php echo $info[1]; ?></span>
                            <strong><?php echo $s['nombre']; ?></strong>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Deuxieme rangee : Top Produits + Commandes recentes -->
        <div class="dashboard-tables">
            <!-- Top Produits -->
            <div class="dashboard-table-card">
                <h3><i class="fas fa-trophy" style="color:#f39c12;"></i> Top Produits</h3>
                <?php if (empty($top_produits)): ?>
                    <div class="chart-empty">
                        <i class="fas fa-box"></i>
                        <p>Aucune vente enregistrée.</p>
                    </div>
                <?php else: ?>
                    <div class="top-produits-list">
                        <?php
                        $rang = 1;
                        $medal_colors = ['#f39c12', '#95a5a6', '#cd7f32'];
                        foreach ($top_produits as $tp):
                            $color = isset($medal_colors[$rang-1]) ? $medal_colors[$rang-1] : '#ccc';
                        ?>
                        <div class="top-produit-item">
                            <span class="top-rang" style="background:<?php echo $color; ?>;"><?php echo $rang; ?></span>
                            <span class="top-nom"><?php echo htmlspecialchars($tp['nom']); ?></span>
                            <span class="top-vendu"><?php echo $tp['total_vendu']; ?> vendus</span>
                        </div>
                        <?php
                        $rang++;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Commandes recentes -->
            <div class="dashboard-table-card" style="flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <h3><i class="fas fa-clock" style="color:#2D9CDB;"></i> Commandes récentes</h3>
                    <a href="index.php?page=admin&action=commandes" class="btn btn-primary btn-sm">
                        Voir toutes <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <?php if (empty($commandes_recentes)): ?>
                    <div class="chart-empty">
                        <i class="fas fa-inbox"></i>
                        <p>Aucune commande pour le moment.</p>
                    </div>
                <?php else: ?>
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Client</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commandes_recentes as $cmd): ?>
                            <tr>
                                <td><strong>#<?php echo $cmd['id_commande']; ?></strong></td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <div class="avatar-initials">
                                            <?php echo strtoupper(substr($cmd['client_nom'], 0, 1)); ?>
                                        </div>
                                        <?php echo htmlspecialchars($cmd['client_nom']); ?>
                                    </div>
                                </td>
                                <td><strong><?php echo number_format($cmd['total'], 2, ',', ' '); ?> DH</strong></td>
                                <td>
                                    <?php
                                    $classe = 'badge-attente'; $texte = 'En attente';
                                    if ($cmd['statut'] == 'confirmee') { $classe = 'badge-confirmee'; $texte = 'Confirmée'; }
                                    elseif ($cmd['statut'] == 'livree')  { $classe = 'badge-livree';   $texte = 'Livrée'; }
                                    elseif ($cmd['statut'] == 'annulee') { $classe = 'badge-annulee';  $texte = 'Annulée'; }
                                    ?>
                                    <span class="badge <?php echo $classe; ?>"><?php echo $texte; ?></span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($cmd['date_commande'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js scripts -->
<?php if (!empty($ventes_mensuelles)): ?>
<script>
<?php
$mois_labels = [];
$mois_ventes = [];
$ventes_inv = array_reverse($ventes_mensuelles);
foreach ($ventes_inv as $v) {
    $mois_labels[] = $v['mois'];
    $mois_ventes[] = floatval($v['total_ventes']);
}
?>
var ctx = document.getElementById('chartVentesDashboard').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($mois_labels); ?>,
        datasets: [{
            label: 'Ventes (DH)',
            data: <?php echo json_encode($mois_ventes); ?>,
            borderColor: '#2D9CDB',
            backgroundColor: 'rgba(45,156,219,0.08)',
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#2D9CDB',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: { callback: function(v) { return v + ' DH'; } }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
<?php endif; ?>

<?php if (!empty($commandes_par_statut)): ?>
<script>
var ctxStatut = document.getElementById('chartStatutDashboard').getContext('2d');
new Chart(ctxStatut, {
    type: 'doughnut',
    data: {
        labels: <?php
            $labels = [];
            $data = [];
            $colors = [];
            $statut_couleurs_js = [
                'en_attente' => '#f39c12',
                'confirmee' => '#27AE60',
                'livree' => '#2D9CDB',
                'annulee' => '#e74c3c'
            ];
            foreach ($commandes_par_statut as $s) {
                $labels[] = ucfirst(str_replace('_', ' ', $s['statut']));
                $data[] = $s['nombre'];
                $colors[] = $statut_couleurs_js[$s['statut']] ?? '#95a5a6';
            }
            echo json_encode($labels);
        ?>,
        datasets: [{
            data: <?php echo json_encode($data); ?>,
            backgroundColor: <?php echo json_encode($colors); ?>,
            borderWidth: 0
        }]
    },
    options: {
        cutout: '70%',
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
        }
    }
});
</script>
<?php endif; ?>

</body>
</html>
