<?php
// ===================================
// Modele Newsletter
// Inscriptions email footer
// ===================================

class Newsletter {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->assurerTable();
    }

    // Creer la table si elle n'existe pas encore
    private function assurerTable() {
        $sql = "CREATE TABLE IF NOT EXISTS newsletter (
            id_newsletter INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(150) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->conn->exec($sql);
    }

    // Inscrire un email (retourne ok, existe, ou invalide)
    public function inscrire($email) {
        $email = trim(strtolower($email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'invalide';
        }

        $sql = "SELECT id_newsletter FROM newsletter WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            return 'existe';
        }

        $sql2 = "INSERT INTO newsletter (email) VALUES (:email)";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute([':email' => $email]);
        return 'ok';
    }
}
?>
