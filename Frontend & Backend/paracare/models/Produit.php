<?php
// ===================================
// Modele Produit
// Gestion des produits parapharmacie
// ===================================

class Produit {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Recuperer tous les produits (avec filtres optionnels et pagination)
    public function getTous($categorie = null, $recherche = null, $page = 1, $par_page = 8, $prix_min = null, $prix_max = null, $note_min = null) {
        $sql = "SELECT p.*, c.nom_categorie, c.slug as cat_slug FROM produits p LEFT JOIN categories c ON p.id_categorie = c.id_categorie WHERE 1=1";
        $params = [];
        if ($categorie) {
            $sql .= " AND c.slug = :cat";
            $params[':cat'] = $categorie;
        }
        if ($recherche) {
            $sql .= " AND (p.nom LIKE :rech OR p.description LIKE :rech2)";
            $params[':rech'] = "%" . $recherche . "%";
            $params[':rech2'] = "%" . $recherche . "%";
        }
        if ($prix_min !== null) {
            $sql .= " AND p.prix >= :pmin";
            $params[':pmin'] = $prix_min;
        }
        if ($prix_max !== null) {
            $sql .= " AND p.prix <= :pmax";
            $params[':pmax'] = $prix_max;
        }
        if ($note_min !== null) {
            $sql .= " AND (" . getNoteSqlCase('p') . ") >= :note_min";
            $params[':note_min'] = $note_min;
        }

        $sql .= " ORDER BY p.created_at DESC";
        $offset = ($page - 1) * $par_page;
        $sql .= " LIMIT " . intval($par_page) . " OFFSET " . intval($offset);

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Compter les produits avec filtres (pour pagination)
    public function compterFiltres($categorie = null, $recherche = null, $prix_min = null, $prix_max = null, $note_min = null) {
        $sql = "SELECT COUNT(*) FROM produits p LEFT JOIN categories c ON p.id_categorie = c.id_categorie WHERE 1=1";
        $params = [];

        if ($categorie) {
            $sql .= " AND c.slug = :cat";
            $params[':cat'] = $categorie;
        }
        if ($recherche) {
            $sql .= " AND (p.nom LIKE :rech OR p.description LIKE :rech2)";
            $params[':rech'] = "%" . $recherche . "%";
            $params[':rech2'] = "%" . $recherche . "%";
        }
        if ($prix_min !== null) {
            $sql .= " AND p.prix >= :pmin";
            $params[':pmin'] = $prix_min;
        }
        if ($prix_max !== null) {
            $sql .= " AND p.prix <= :pmax";
            $params[':pmax'] = $prix_max;
        }
        if ($note_min !== null) {
            $sql .= " AND (" . getNoteSqlCase('p') . ") >= :note_min";
            $params[':note_min'] = $note_min;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    // Recuperer un produit par son ID
    public function getParId($id) {
        $sql = "SELECT p.*, c.nom_categorie, c.slug as cat_slug FROM produits p LEFT JOIN categories c ON p.id_categorie = c.id_categorie WHERE p.id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Produits recents pour la page d'accueil
    public function getRecents($limite = 8) {
        $sql = "SELECT p.*, c.nom_categorie, c.slug as cat_slug FROM produits p LEFT JOIN categories c ON p.id_categorie = c.id_categorie ORDER BY p.created_at DESC LIMIT $limite";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Produits de la meme categorie
    public function getParCategorie($id_categorie, $exclure_id = 0) {
        $sql = "SELECT p.*, c.nom_categorie, c.slug as cat_slug FROM produits p LEFT JOIN categories c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = :cat AND p.id_produit != :exclure LIMIT 4";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cat' => $id_categorie, ':exclure' => $exclure_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un produit (admin)
    public function ajouter($nom, $description, $prix, $stock, $image, $id_categorie) {
        $sql = "INSERT INTO produits (nom, description, prix, stock, image, id_categorie) VALUES (:nom, :desc, :prix, :stock, :img, :cat)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':desc' => $description,
            ':prix' => $prix,
            ':stock' => $stock,
            ':img' => $image,
            ':cat' => $id_categorie
        ]);
    }

    // Modifier un produit
    public function modifier($id, $nom, $description, $prix, $stock, $image, $id_categorie) {
        $sql = "UPDATE produits SET nom = :nom, description = :desc, prix = :prix, stock = :stock, image = :img, id_categorie = :cat WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':desc' => $description,
            ':prix' => $prix,
            ':stock' => $stock,
            ':img' => $image,
            ':cat' => $id_categorie
        ]);
    }

    // Supprimer un produit
    public function supprimer($id) {
        $sql = "DELETE FROM produits WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Compter les produits
    public function compter() {
        $sql = "SELECT COUNT(*) FROM produits";
        return $this->conn->query($sql)->fetchColumn();
    }

    // Diminuer le stock apres commande
    public function diminuerStock($id, $quantite) {
        $sql = "UPDATE produits SET stock = stock - :qty WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id, ':qty' => $quantite]);
    }
}
?>
