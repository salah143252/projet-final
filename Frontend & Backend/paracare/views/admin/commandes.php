<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Commandes - ParaCare Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <?php require_once 'views/admin/sidebar.php'; ?>

    <!-- Contenu principal -->
    <div class="admin-content">
        <div class="admin-header">
            <div>
                <h1>Gestion des Commandes</h1>
                <p style="color:#888; font-size:13px; margin-top:3px;"><?php echo count($commandes); ?> commande(s) au total</p>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <!-- Filtre rapide par statut -->
                <select onchange="filtrerCommandes(this.value)" style="padding:8px 14px; border:1px solid #ddd; border-radius:8px; font-family:'Poppins',sans-serif; font-size:13px; cursor:pointer; outline:none;">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="confirmee">Confirmée</option>
                    <option value="livree">Livrée</option>
                    <option value="annulee">Annulée</option>
                </select>
                <!-- Bouton export CSV simulation -->
                <button onclick="exportCSV()" class="btn btn-success">
                    <i class="fas fa-file-csv"></i> Exporter CSV
                </button>
            </div>
        </div>

        <!-- Resume rapide des statuts -->
        <?php
        $nb_attente = 0; $nb_confirmee = 0; $nb_livree = 0; $nb_annulee = 0;
        foreach ($commandes as $c) {
            if ($c['statut'] == 'en_attente') $nb_attente++;
            elseif ($c['statut'] == 'confirmee') $nb_confirmee++;
            elseif ($c['statut'] == 'livree') $nb_livree++;
            elseif ($c['statut'] == 'annulee') $nb_annulee++;
        }
        ?>
        <div class="commandes-stats">
            <div class="cmd-stat-item" style="border-left-color:#f39c12;">
                <span class="cmd-stat-count"><?php echo $nb_attente; ?></span>
                <span class="cmd-stat-label">En attente</span>
            </div>
            <div class="cmd-stat-item" style="border-left-color:#27AE60;">
                <span class="cmd-stat-count"><?php echo $nb_confirmee; ?></span>
                <span class="cmd-stat-label">Confirmées</span>
            </div>
            <div class="cmd-stat-item" style="border-left-color:#2D9CDB;">
                <span class="cmd-stat-count"><?php echo $nb_livree; ?></span>
                <span class="cmd-stat-label">Livrées</span>
            </div>
            <div class="cmd-stat-item" style="border-left-color:#e74c3c;">
                <span class="cmd-stat-count"><?php echo $nb_annulee; ?></span>
                <span class="cmd-stat-label">Annulées</span>
            </div>
        </div>

        <!-- Tableau des commandes -->
        <?php if (empty($commandes)): ?>
            <div class="empty-state">
                <i class="fas fa-shopping-bag"></i>
                <h3>Aucune commande pour le moment</h3>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Client</th>
                        <th>Adresse</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Paiement</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $cmd): ?>
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
                        <td>
                            <span title="<?php echo htmlspecialchars($cmd['adresse_livraison']); ?>">
                                <?php echo htmlspecialchars(substr($cmd['adresse_livraison'], 0, 30)) . '...'; ?>
                            </span>
                        </td>
                        <td><strong><?php echo number_format($cmd['total'], 2, ',', ' '); ?> DH</strong></td>
                        <td>
                            <?php
                            $classe = 'badge-attente';
                            $texte = 'En attente';
                            if ($cmd['statut'] == 'confirmee') { $classe = 'badge-confirmee'; $texte = 'Confirmée'; }
                            elseif ($cmd['statut'] == 'livree') { $classe = 'badge-livree'; $texte = 'Livrée'; }
                            elseif ($cmd['statut'] == 'annulee') { $classe = 'badge-annulee'; $texte = 'Annulée'; }
                            ?>
                            <span class="badge <?php echo $classe; ?>"><?php echo $texte; ?></span>
                        </td>
                        <td>
                            <?php if ($cmd['statut_paiement'] == 'paye'): ?>
                                <span class="paiement-status paye"><i class="fas fa-check-circle"></i> Payé</span>
                            <?php else: ?>
                                <span class="paiement-status non-paye"><i class="fas fa-clock"></i> Non payé</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($cmd['date_commande'])); ?></td>
                        <td>
                            <!-- Formulaire pour changer le statut -->
                            <form method="POST" action="index.php?page=admin&action=commandes" class="statut-form">
                                <input type="hidden" name="id_commande" value="<?php echo $cmd['id_commande']; ?>">
                                <select name="nouveau_statut" class="statut-select">
                                    <option value="en_attente" <?php echo ($cmd['statut'] == 'en_attente') ? 'selected' : ''; ?>>En attente</option>
                                    <option value="confirmee" <?php echo ($cmd['statut'] == 'confirmee') ? 'selected' : ''; ?>>Confirmée</option>
                                    <option value="livree" <?php echo ($cmd['statut'] == 'livree') ? 'selected' : ''; ?>>Livrée</option>
                                    <option value="annulee" <?php echo ($cmd['statut'] == 'annulee') ? 'selected' : ''; ?>>Annulée</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm" title="Mettre à jour">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
<!-- Script filtre et export -->
<script>
// Filtrer les lignes du tableau par statut
function filtrerCommandes(statut) {
    var lignes = document.querySelectorAll('tbody tr');
    lignes.forEach(function(ligne) {
        if (!statut) {
            ligne.style.display = '';
        } else {
            var badge = ligne.querySelector('.badge');
            if (badge) {
                var texte = badge.textContent.toLowerCase();
                var visible = texte.indexOf(statut.replace('_', ' ')) !== -1 ||
                              (statut === 'en_attente' && texte.indexOf('attente') !== -1) ||
                              (statut === 'confirmee' && texte.indexOf('confirm') !== -1) ||
                              (statut === 'livree' && texte.indexOf('livr') !== -1) ||
                              (statut === 'annulee' && texte.indexOf('annul') !== -1);
                ligne.style.display = visible ? '' : 'none';
            }
        }
    });
}
// Export CSV (simulation)
function exportCSV() {
    var rows = [];
    rows.push(['N°', 'Client', 'Total', 'Statut', 'Paiement', 'Date'].join(';'));
    document.querySelectorAll('tbody tr').forEach(function(tr) {
        if (tr.style.display !== 'none') {
            var cells = tr.querySelectorAll('td');
            var row = [];
            [0,1,3,4,5,6].forEach(function(i) {
                if (cells[i]) row.push(cells[i].innerText.replace(/\n/g,' ').trim());
            });
            rows.push(row.join(';'));
        }
    });
    var blob = new Blob([rows.join('\n')], { type: 'text/csv;charset=utf-8;' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'commandes_paracare.csv';
    a.click();
}
</script>
