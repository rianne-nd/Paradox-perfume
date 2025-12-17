<?php
require 'api/db.php';

// CHANGE THESE VALUES TO CREATE YOUR ADMIN USER
$new_username = 'admin';
$new_password = 'admin123'; // Change this to a strong password!

// Hash the password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

try {
    // Check if user exists in the 'admins' table
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
    $stmt->execute([$new_username]);
    
    if ($stmt->fetch()) {
        // Update existing user
        $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE username = ?");
        $stmt->execute([$hashed_password, $new_username]);
        echo "Admin user '$new_username' updated successfully. You can now login.";
    } else {
        // Create new user
        $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$new_username, $hashed_password]);
        echo "Admin user '$new_username' created successfully. You can now login.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>