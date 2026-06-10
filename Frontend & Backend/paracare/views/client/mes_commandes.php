<!-- Page historique des commandes -->

<section class="section">
    <h2 class="section-title">Mes Commandes</h2>

    <?php if (empty($commandes)): ?>
        <div class="empty-state">
            <i class="fas fa-receipt"></i>
            <h3>Vous n'avez pas encore de commande</h3>
            <p>Parcourez nos produits et passez votre première commande.</p>
            <a href="index.php?page=produits" class="btn-lien">Voir les produits</a>
        </div>
    <?php else: ?>
        <div class="commandes-list">
            <table>
                <thead>
                    <tr>
                        <th>N° Commande</th>
                        <th>Date</th>
                        <th>Adresse</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Paiement</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $cmd): ?>
                    <tr>
                        <td><strong>#<?php echo $cmd['id_commande']; ?></strong></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($cmd['date_commande'])); ?></td>
                        <td><?php echo htmlspecialchars(substr($cmd['adresse_livraison'], 0, 40)) . '...'; ?></td>
                        <td><strong><?php echo number_format($cmd['total'], 2, ',', ' '); ?> DH</strong></td>
                        <td>
                            <?php
                            // Afficher le badge selon le statut
                            $classe_badge = 'badge-attente';
                            $texte_statut = 'En attente';

                            if ($cmd['statut'] == 'confirmee') {
                                $classe_badge = 'badge-confirmee';
                                $texte_statut = 'Confirmée';
                            } elseif ($cmd['statut'] == 'livree') {
                                $classe_badge = 'badge-livree';
                                $texte_statut = 'Livrée';
                            } elseif ($cmd['statut'] == 'annulee') {
                                $classe_badge = 'badge-annulee';
                                $texte_statut = 'Annulée';
                            }
                            ?>
                            <span class="badge <?php echo $classe_badge; ?>"><?php echo $texte_statut; ?></span>
                        </td>
                        <td>
                            <?php if ($cmd['statut_paiement'] == 'paye'): ?>
                                <span style="color:#27AE60;"><i class="fas fa-check"></i> Payé</span>
                            <?php else: ?>
                                <span style="color:#e67e22;"><i class="fas fa-clock"></i> Non payé</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
