<?php
require_once 'api/db.php';

try {
    echo "<h2>Updating Product Image Paths to WebP...</h2>";

    // 1. Update .jpg to .webp
    $sql1 = "UPDATE products SET image_path = REPLACE(image_path, '.jpg', '.webp') WHERE image_path LIKE '%.jpg'";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    echo "Updated " . $stmt1->rowCount() . " products from .jpg to .webp.<br>";

    // 2. Update .png to .webp
    $sql2 = "UPDATE products SET image_path = REPLACE(image_path, '.png', '.webp') WHERE image_path LIKE '%.png'";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    echo "Updated " . $stmt2->rowCount() . " products from .png to .webp.<br>";
    
    // 3. Fix double extensions (e.g. .png.png -> .png.webp -> .webp)
    // This handles cases where the original path was like "image.png.png" (which happened with Cool Water)
    // After step 2, it would become "image.png.webp". We want "image.webp".
    
    $sql3 = "UPDATE products SET image_path = REPLACE(image_path, '.png.webp', '.webp') WHERE image_path LIKE '%.png.webp'";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute();
    echo "Fixed " . $stmt3->rowCount() . " double extensions (.png.webp -> .webp).<br>";

    // 3.5 Fix .webp.webp (User reported specific issue)
    $sql35 = "UPDATE products SET image_path = REPLACE(image_path, '.webp.webp', '.webp') WHERE image_path LIKE '%.webp.webp'";
    $stmt35 = $pdo->prepare($sql35);
    $stmt35->execute();
    echo "Fixed " . $stmt35->rowCount() . " double extensions (.webp.webp -> .webp).<br>";

    // 4. Fix .jpg.webp just in case
    $sql4 = "UPDATE products SET image_path = REPLACE(image_path, '.jpg.webp', '.webp') WHERE image_path LIKE '%.jpg.webp'";
    $stmt4 = $pdo->prepare($sql4);
    $stmt4->execute();
    echo "Fixed " . $stmt4->rowCount() . " double extensions (.jpg.webp -> .webp).<br>";

    echo "<h3>Database image paths updated successfully!</h3>";
    echo "<p>You can now delete this file.</p>";
    echo "<a href='index.php'>Go back to Home</a>";

} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
}
?>
