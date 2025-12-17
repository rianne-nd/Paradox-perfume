<?php
require_once 'api/db.php';

try {
    echo "<h2>Fixing Cool Water Image Path...</h2>";

    // Fix double .webp extension (caused by replacing .png.png -> .webp.webp)
    $sql = "UPDATE products SET image_path = REPLACE(image_path, '.webp.webp', '.webp') WHERE image_path LIKE '%.webp.webp'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "Fixed " . $stmt->rowCount() . " products with double .webp extension.<br>";
    } else {
        echo "No double .webp extensions found.<br>";
    }

    // Also check for the specific case just to be sure
    $sql2 = "SELECT name, image_path FROM products WHERE name LIKE '%Cool Water%'";
    $stmt2 = $pdo->query($sql2);
    $product = $stmt2->fetch();

    if ($product) {
        echo "Current path for Cool Water: " . htmlspecialchars($product['image_path']) . "<br>";
    } else {
        echo "Product 'Cool Water' not found.<br>";
    }

    echo "<p>Done! <a href='index.php'>Go back to Home</a></p>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>