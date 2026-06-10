<?php
// ===================================
// Modele Categorie
// ===================================

class Categorie {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Recuperer toutes les categories
    public function getTous() {
        $sql = "SELECT * FROM categories ORDER BY nom_categorie";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recuperer une categorie par slug
    public function getParSlug($slug) {
        $sql = "SELECT * FROM categories WHERE slug = :slug";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
