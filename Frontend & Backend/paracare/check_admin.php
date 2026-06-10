<?php
// Diagnostic script to check admin user
require_once 'config/db.php';

echo "<h2>Admin User Diagnostic</h2>";

// Check if admin user exists
$stmt = $connexion->query("SELECT id_user, nom, prenom, email, role, password FROM users WHERE email = 'admin@paracare.com'");
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<p style='color:red;'>ERROR: No admin user found with email admin@paracare.com</p>";
    
    // Check if any admin exists
    $stmt = $connexion->query("SELECT id_user, email, role FROM users WHERE role = 'admin'");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($admins)) {
        echo "<p style='color:red;'>No admin users exist in the database at all.</p>";
    } else {
        echo "<p>Other admin users found:</p>";
        foreach ($admins as $a) {
            echo "<p>ID: {$a['id_user']}, Email: {$a['email']}</p>";
        }
    }
} else {
    echo "<p style='color:green;'>Admin user found:</p>";
    echo "<ul>";
    echo "<li>ID: {$admin['id_user']}</li>";
    echo "<li>Name: {$admin['prenom']} {$admin['nom']}</li>";
    echo "<li>Email: {$admin['email']}</li>";
    echo "<li>Role: {$admin['role']}</li>";
    echo "<li>Password hash: " . substr($admin['password'], 0, 30) . "...</li>";
    echo "</ul>";
    
    // Test password verification
    $test_passwords = ['admin123', 'password', 'admin', '123456'];
    echo "<h3>Password Verification Tests:</h3>";
    foreach ($test_passwords as $pwd) {
        if (password_verify($pwd, $admin['password'])) {
            echo "<p style='color:green;'>✓ Password '{$pwd}' works!</p>";
        } else {
            echo "<p style='color:red;'>✗ Password '{$pwd}' does NOT work</p>";
        }
    }
}

// Check all users
echo "<hr><h3>All Users in Database:</h3>";
$stmt = $connexion->query("SELECT id_user, email, role FROM users ORDER BY id_user");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $u) {
    echo "<p>ID: {$u['id_user']}, Email: {$u['email']}, Role: {$u['role']}</p>";
}
?>
