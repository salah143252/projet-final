<?php
// Comprehensive Admin Password Fix Script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>ParaCare - Comprehensive Admin Password Fix</h2>";
echo "<hr>";

// Step 1: Test database connection
try {
    require_once 'config/db.php';
    echo "<p style='color:green;'>✓ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Step 2: Check if admin user exists
echo "<h3>Step 1: Check Admin User</h3>";
$stmt = $connexion->query("SELECT id_user, email, role, password FROM users WHERE email = 'admin@paracare.com'");
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<p style='color:red;'>✗ Admin user not found. Creating...</p>";
    
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    echo "<p>Generated hash for 'admin123': " . substr($hash, 0, 30) . "...</p>";
    
    $stmt = $connexion->prepare("INSERT INTO users (nom, prenom, email, password, role, email_verified) VALUES ('Admin', 'ParaCare', 'admin@paracare.com', :pass, 'admin', TRUE)");
    $result = $stmt->execute([':pass' => $hash]);
    
    if ($result) {
        echo "<p style='color:green;'>✓ Admin user created successfully</p>";
    } else {
        echo "<p style='color:red;'>✗ Failed to create admin user</p>";
        exit;
    }
} else {
    echo "<p style='color:green;'>✓ Admin user found: ID={$admin['id_user']}, Role={$admin['role']}</p>";
    echo "<p>Current password hash: " . substr($admin['password'], 0, 30) . "...</p>";
}

// Step 3: Test current password
echo "<h3>Step 2: Test Current Password</h3>";
$stmt = $connexion->query("SELECT password FROM users WHERE email = 'admin@paracare.com'");
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

$test_passwords = ['admin123', 'password', 'admin'];
foreach ($test_passwords as $pwd) {
    if (password_verify($pwd, $admin['password'])) {
        echo "<p style='color:green;'>✓ Current password is: '$pwd'</p>";
        $current_pwd = $pwd;
        break;
    }
}

if (!isset($current_pwd)) {
    echo "<p style='color:orange;'>⚠ Current password doesn't match common passwords. Updating to 'admin123'...</p>";
}

// Step 4: Update password to admin123
echo "<h3>Step 3: Update Password to 'admin123'</h3>";
$new_hash = password_hash('admin123', PASSWORD_DEFAULT);
echo "<p>New hash for 'admin123': " . substr($new_hash, 0, 30) . "...</p>";

$stmt = $connexion->prepare("UPDATE users SET password = :pass WHERE email = 'admin@paracare.com'");
$result = $stmt->execute([':pass' => $new_hash]);

if ($result) {
    echo "<p style='color:green;'>✓ Password updated successfully</p>";
} else {
    echo "<p style='color:red;'>✗ Failed to update password</p>";
    exit;
}

// Step 5: Verify the update
echo "<h3>Step 4: Verify Update</h3>";
$stmt = $connexion->query("SELECT password FROM users WHERE email = 'admin@paracare.com'");
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (password_verify('admin123', $admin['password'])) {
    echo "<p style='color:green;'>✓ Password verification successful - 'admin123' now works!</p>";
} else {
    echo "<p style='color:red;'>✗ Password verification failed</p>";
}

// Step 6: Display login credentials
echo "<hr>";
echo "<h3>Login Credentials:</h3>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><td><strong>Email:</strong></td><td>admin@paracare.com</td></tr>";
echo "<tr><td><strong>Password:</strong></td><td>admin123</td></tr>";
echo "</table>";

echo "<hr>";
echo "<p style='color:red;'><strong>IMPORTANT: Delete this file (fix_admin_comprehensive.php) after fixing!</strong></p>";
echo "<p><a href='index.php?page=connexion'>Go to Login Page</a></p>";
?>
