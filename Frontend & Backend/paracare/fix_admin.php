<?php
// Temporary script to fix admin password - access via browser
require_once 'config/db.php';

echo "<h2>ParaCare Admin Password Fix</h2>";

// Step 1: Check if admin user exists
$stmt = $connexion->query("SELECT id_user, email, role, password FROM users WHERE email = 'admin@paracare.com'");
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<p style='color:red;'>ERROR: No user found with email admin@paracare.com</p>";
    echo "<p>Creating admin user...</p>";
    
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $connexion->prepare("INSERT INTO users (nom, prenom, email, password, role, email_verified) VALUES ('Admin', 'ParaCare', 'admin@paracare.com', :pass, 'admin', TRUE)");
    $stmt->execute([':pass' => $hash]);
    echo "<p style='color:green;'>Admin user created successfully!</p>";
} else {
    echo "<p>Admin user found: ID={$admin['id_user']}, Role={$admin['role']}</p>";
    echo "<p>Current hash: " . substr($admin['password'], 0, 20) . "...</p>";
    
    // Test if current password is 'admin123'
    if (password_verify('admin123', $admin['password'])) {
        echo "<p style='color:green;'>Password is already correctly set to 'admin123'</p>";
    } else {
        // Test what the current password actually is
        if (password_verify('password', $admin['password'])) {
            echo "<p style='color:orange;'>Current password is 'password' (not 'admin123'). Fixing now...</p>";
        } else {
            echo "<p style='color:orange;'>Current password is unknown. Fixing now...</p>";
        }
        
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $connexion->prepare("UPDATE users SET password = :pass WHERE email = 'admin@paracare.com'");
        $stmt->execute([':pass' => $hash]);
        echo "<p style='color:green;'>Password updated to 'admin123'</p>";
    }
}

echo "<hr>";
echo "<h3>Login credentials:</h3>";
echo "<p><strong>Email:</strong> admin@paracare.com</p>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<hr>";
echo "<p style='color:red;'><strong>DELETE this file (fix_admin.php) after fixing!</strong></p>";
