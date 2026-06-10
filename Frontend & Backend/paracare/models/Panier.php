<?php
// ===================================
// Modele Panier
// Gestion du panier d'achat
// ===================================

class Panier {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Recuperer ou creer le panier d'un utilisateur
    public function getPanier($id_user) {
        $sql = "SELECT * FROM panier WHERE id_user = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_user]);
        $panier = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si le panier n'existe pas on le cree
        if (!$panier) {
            $sql2 = "INSERT INTO panier (id_user) VALUES (:id)";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([':id' => $id_user]);
            // Recuperer le panier cree
            $stmt->execute([':id' => $id_user]);
            $panier = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return $panier;
    }

    // Recuperer les articles du panier (avec slug categorie pour promo)
    public function getArticles($id_panier) {
        $sql = "SELECT pi.*, p.nom, p.prix, p.image, p.stock, p.id_produit,
                       c.nom_categorie, c.slug AS cat_slug
                FROM panier_items pi 
                INNER JOIN produits p ON pi.id_produit = p.id_produit 
                LEFT JOIN categories c ON p.id_categorie = c.id_categorie 
                WHERE pi.id_panier = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_panier]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un article au panier
    public function ajouterArticle($id_panier, $id_produit, $quantite = 1) {
        // Verifier si le produit existe deja dans le panier
        $sql = "SELECT * FROM panier_items WHERE id_panier = :panier AND id_produit = :produit";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':panier' => $id_panier, ':produit' => $id_produit]);
        $existe = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existe) {
            // Mettre a jour la quantite
            $nouvelleQte = $existe['quantite'] + $quantite;
            $sql2 = "UPDATE panier_items SET quantite = :qty WHERE id_item = :id";
            $stmt2 = $this->conn->prepare($sql2);
            return $stmt2->execute([':qty' => $nouvelleQte, ':id' => $existe['id_item']]);
        } else {
            // Inserer un nouvel article
            $sql2 = "INSERT INTO panier_items (id_panier, id_produit, quantite) VALUES (:panier, :produit, :qty)";
            $stmt2 = $this->conn->prepare($sql2);
            return $stmt2->execute([':panier' => $id_panier, ':produit' => $id_produit, ':qty' => $quantite]);
        }
    }

    // Modifier la quantite d'un article
    public function modifierQuantite($id_item, $quantite) {
        if ($quantite <= 0) {
            return $this->supprimerArticle($id_item);
        }
        $sql = "UPDATE panier_items SET quantite = :qty WHERE id_item = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':qty' => $quantite, ':id' => $id_item]);
    }

    // Supprimer un article du panier
    public function supprimerArticle($id_item) {
        $sql = "DELETE FROM panier_items WHERE id_item = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id_item]);
    }

    // Calculer le total du panier (avec promotions -15%)
    public function getTotal($id_panier) {
        $articles = $this->getArticles($id_panier);
        $total = 0;
        foreach ($articles as $article) {
            $total += getPrixEffectif($article) * $article['quantite'];
        }
        return round($total, 2);
    }

    // Economie totale des promotions dans le panier
    public function getEconomiePromo($id_panier) {
        $articles = $this->getArticles($id_panier);
        $economie = 0;
        foreach ($articles as $article) {
            if (aPromotion($article)) {
                $economie += ($article['prix'] - getPrixEffectif($article)) * $article['quantite'];
            }
        }
        return round($economie, 2);
    }

    // Compter les articles dans le panier
    public function compterArticles($id_panier) {
        $sql = "SELECT SUM(quantite) as nb FROM panier_items WHERE id_panier = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id_panier]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['nb'] ? $res['nb'] : 0;
    }

    // Vider le panier apres commande
    public function vider($id_panier) {
        $sql = "DELETE FROM panier_items WHERE id_panier = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id_panier]);
    }
}
?>
