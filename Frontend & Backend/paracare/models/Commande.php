<?php
// ===================================
// Modele Commande
// Gestion des commandes clients
// ===================================

class Commande {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Creer une nouvelle commande
    public function creer($id_user, $adresse, $total, $articles) {
        // Debut de transaction
        $this->conn->beginTransaction();

        try {
            // Inserer la commande
            $sql = "INSERT INTO commandes (id_user, adresse_livraison, total) VALUES (:user, :adresse, :total)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user' => $id_user,
                ':adresse' => $adresse,
                ':total' => $total
            ]);
            $id_commande = $this->conn->lastInsertId();

            // Inserer les details de la commande
            $sql2 = "INSERT INTO commande_details (id_commande, id_produit, quantite, prix_unitaire) VALUES (:cmd, :prod, :qty, :prix)";
            $stmt2 = $this->conn->prepare($sql2);

            foreach ($articles as $article) {
                $stmt2->execute([
                    ':cmd' => $id_commande,
                    ':prod' => $article['id_produit'],
                    ':qty' => $article['quantite'],
                    ':prix' => $article['prix']
                ]);
            }

            $this->conn->commit();
            return $id_commande;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Recuperer les commandes d'un utilisateur
    public function getParUtilisateur($id_user) {
        $sql = "SELECT * FROM commandes WHERE id_user = :id ORDER BY date_commande DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recuperer toutes les commandes (admin)
    public function getTous() {
        $sql = "SELECT c.*, CONCAT(u.prenom, ' ', u.nom) as client_nom 
                FROM commandes c 
                INNER JOIN users u ON c.id_user = u.id_user 
                ORDER BY c.date_commande DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Changer le statut d'une commande
    public function changerStatut($id, $statut) {
        $sql = "UPDATE commandes SET statut = :statut WHERE id_commande = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':statut' => $statut, ':id' => $id]);
    }

    // Compter les commandes
    public function compter() {
        $sql = "SELECT COUNT(*) FROM commandes";
        return $this->conn->query($sql)->fetchColumn();
    }

    // Calculer le chiffre d'affaires
    public function getChiffreAffaires() {
        $sql = "SELECT IFNULL(SUM(total), 0) FROM commandes WHERE statut != 'annulee'";
        return $this->conn->query($sql)->fetchColumn();
    }

    // Ventes mensuelles (pour Chart.js)
    public function getVentesMensuelles() {
        $sql = "SELECT DATE_FORMAT(date_commande, '%Y-%m') as mois, 
                       SUM(total) as total_ventes, 
                       COUNT(*) as nb_commandes 
                FROM commandes 
                WHERE statut != 'annulee' 
                GROUP BY mois 
                ORDER BY mois DESC 
                LIMIT 6";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Commandes par statut (pour le graphique)
    public function getParStatut() {
        $sql = "SELECT statut, COUNT(*) as nombre FROM commandes GROUP BY statut";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Produits les plus vendus
    public function getTopProduits($limite = 5) {
        $sql = "SELECT p.nom, SUM(cd.quantite) as total_vendu 
                FROM commande_details cd 
                INNER JOIN produits p ON cd.id_produit = p.id_produit 
                GROUP BY p.id_produit 
                ORDER BY total_vendu DESC 
                LIMIT $limite";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
