<?php
// ===================================
// Modele Utilisateur
// Gestion des utilisateurs (CRUD)
// ===================================

class Utilisateur {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Inscription d'un nouveau client
    public function inscrire($nom, $prenom, $email, $motdepasse, $telephone, $adresse) {
        $hash = password_hash($motdepasse, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nom, prenom, email, password, telephone, adresse) VALUES (:nom, :prenom, :email, :pass, :tel, :adresse)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':pass' => $hash,
            ':tel' => $telephone,
            ':adresse' => $adresse
        ]);
        return $this->conn->lastInsertId();
    }

    // Connexion
    public function connecter($email, $motdepasse) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($motdepasse, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Verifier si email existe deja
    public function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    // Recuperer tous les utilisateurs (admin)
    public function getTous() {
        $sql = "SELECT id_user, nom, prenom, email, telephone, role, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recuperer un utilisateur par ID
    public function getParId($id) {
        $sql = "SELECT * FROM users WHERE id_user = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Supprimer un utilisateur
    public function supprimer($id) {
        $sql = "DELETE FROM users WHERE id_user = :id AND role != 'admin'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Compter les clients
    public function compterClients() {
        $sql = "SELECT COUNT(*) FROM users WHERE role = 'client'";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchColumn();
    }
}
?>
