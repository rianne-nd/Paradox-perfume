<?php
require 'db.php';

// CHANGE THESE VALUES TO CREATE YOUR ADMIN USER
$new_username = 'admin';
$new_password = 'admin123'; // Change this to a strong password!

// Hash the password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$new_username]);
    
    if ($stmt->fetch()) {
        // Update existing user
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$hashed_password, $new_username]);
        echo "User '$new_username' updated successfully. You can now login.";
    } else {
        // Create new user
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$new_username, $hashed_password]);
        echo "User '$new_username' created successfully. You can now login.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>