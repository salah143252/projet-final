<?php
// ===================================
// Connexion a la base de donnees
// ParaCare - Parapharmacie en Ligne
// ===================================

$host = "localhost";
$dbname = "paracare";
$user = "root";
$pass = "";

try {
    $connexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
