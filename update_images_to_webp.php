<?php
require_once 'api/db.php';

try {
    echo "<h2>Updating Product Image Paths to WebP...</h2>";

    // Update .jpg to .webp
    $sql1 = "UPDATE products SET image_path = REPLACE(image_path, '.jpg', '.webp') WHERE image_path LIKE '%.jpg'";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    echo "Updated " . $stmt1->rowCount() . " products from .jpg to .webp.<br>";

    // Update .png to .webp
    $sql2 = "UPDATE products SET image_path = REPLACE(image_path, '.png', '.webp') WHERE image_path LIKE '%.png'";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    echo "Updated " . $stmt2->rowCount() . " products from .png to .webp.<br>";
    
    // Fix the double extension if it exists (e.g. .png.png -> .png.webp -> .webp)
    // First handle the specific case from setup_products.php: "Cool Water (Men & Women).png.png"
    // If it was inserted as .png.png, the above replace made it .png.webp.
    // We want it to be just .webp
    
    $sql3 = "UPDATE products SET image_path = REPLACE(image_path, '.png.webp', '.webp') WHERE image_path LIKE '%.png.webp'";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute();
    echo "Fixed " . $stmt3->rowCount() . " double extensions (.png.webp -> .webp).<br>";

    echo "<h3>Database image paths updated successfully!</h3>";
    echo "<p>You can now delete this file.</p>";
    echo "<a href='index.php'>Go back to Home</a>";

} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
}
?>