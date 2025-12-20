<?php
session_start();
require '../api/db.php'; // Connects to the database

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // FIX 1: Change table from 'admins' to 'users'
    // FIX 2: Select 'password' (not password_hash) to match your DB
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // FIX 3: Verify using the fetched 'password' column
    if ($user && password_verify($password, $user['password'])) {
        // Success: Set session variables
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Paradox Manila</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; }
        .login-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; }
        .btn-login { width: 100%; padding: 0.75rem; background: #333; color: white; border: none; cursor: pointer; }
        .btn-login:hover { background: #555; }
        .error { color: red; margin-bottom: 1rem; text-align: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Admin Login</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <p style="text-align:center; margin-top:10px;"><a href="../index.php">Back to Shop</a></p>
    </div>
</body>
</html>
