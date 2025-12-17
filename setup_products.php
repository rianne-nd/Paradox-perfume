<?php
// setup_products.php
// Run this ONCE to populate your database with the initial products.

require_once 'api/db.php';

$products = [
    // Floral Reverie
    [ "name" => "Burberry Women", "collection" => "floral", "price" => 150, "description" => "A classic, elegant scent for the modern woman.", "image" => "Images/THE FLORAL REVERIE COLLECTION/Burberry Women.webp" ],
    [ "name" => "Omnia Amethyste", "collection" => "floral", "price" => 150, "description" => "A powdery floral scent inspired by shimmering hues of amethyst gemstones.", "image" => "Images/THE FLORAL REVERIE COLLECTION/Omnia Amethyste.webp" ],
    [ "name" => "Eclat D’Arpege", "collection" => "floral", "price" => 150, "description" => "A delicate, fruity floral fragrance. Soft and romantic.", "image" => "Images/THE FLORAL REVERIE COLLECTION/Eclat D’Arpege.webp" ],
    [ "name" => "Eternity (Women)", "collection" => "floral", "price" => 150, "description" => "A timeless blend of white flowers and soft woods.", "image" => "Images/THE FLORAL REVERIE COLLECTION/Eternity (Women).webp" ],
    
    // Sunlit Essence (Citrus)
    [ "name" => "Light Blue", "collection" => "citrus", "price" => 150, "description" => "Zesty, vibrant, and full of life. Captures the essence of a sunny day.", "image" => "Images/CITRUS COLLECTION — THE SUNLIT ESSENCE/Light Blue.webp" ],
    [ "name" => "Happy (Men & Women)", "collection" => "citrus", "price" => 150, "description" => "Pure joy in a bottle. A hint of citrus, a wealth of flowers.", "image" => "Images/CITRUS COLLECTION — THE SUNLIT ESSENCE/Happy (Men & Women).webp" ],
    [ "name" => "Cold", "collection" => "citrus", "price" => 150, "description" => "Crisp, cooling citrus. Refreshing and energizing.", "image" => "Images/CITRUS COLLECTION — THE SUNLIT ESSENCE/Cold.webp" ],

    // Fruity & Unique Scents
    [ "name" => "English Pear & Freesia", "collection" => "fruity", "price" => 150, "description" => "Crisp, elegant fruit paired with subtle floral notes. (Inspired by Jo Malone)", "image" => "Images/FRUITY & UNIQUE SCENTS — THE JUICY BOTANICALS/English Pear & Freesia.webp" ],
    [ "name" => "Nectarine Blossom & Honey", "collection" => "fruity", "price" => 150, "description" => "Juicy, luscious sweetness and honeyed delight. (Inspired by Jo Malone)", "image" => "Images/FRUITY & UNIQUE SCENTS — THE JUICY BOTANICALS/Nectarine Blossom & Honey.webp" ],

    // Ocean Air (Aquatic)
    [ "name" => "Cool Water", "collection" => "aquatic", "price" => 150, "description" => "The essence of ocean freshness. Crisp, clean, and refreshing.", "image" => "Images/FRESH & AQUATIC COLLECTION — THE OCEAN AIR/Cool Water (Men & Women).webp" ],
    [ "name" => "Aqva Pour Homme", "collection" => "aquatic", "price" => 150, "description" => "Noble and masculine, evoking the power and beauty of the sea.", "image" => "Images/FRESH & AQUATIC COLLECTION — THE OCEAN AIR/Aqva Pour Homme.webp" ],

    // Power Series (Aromatic/Woody)
    [ "name" => "Eros", "collection" => "power", "price" => 150, "description" => "Love, passion, beauty, and desire. A unique aura of sensuality.", "image" => "Images/AROMATIC  SWEET BOLDNESS — THE POWER SERIES/Eros.webp" ],
    [ "name" => "Vanilla & Anise", "collection" => "power", "price" => 150, "description" => "A modern story of vanilla. The fragile vanilla orchid, perfect in its detail.", "image" => "Images/AROMATIC  SWEET BOLDNESS — THE POWER SERIES/Vanilla & Anise.webp" ],
    [ "name" => "Eternity (Men)", "collection" => "power", "price" => 150, "description" => "Distinctive. Romantic. Timeless. A classic fougère scent.", "image" => "Images/AROMATIC  SWEET BOLDNESS — THE POWER SERIES/Eternity (Men).webp" ]
];

try {
    $stmt = $pdo->prepare("INSERT INTO products (name, collection, price, description, image_path) VALUES (?, ?, ?, ?, ?)");

    foreach ($products as $p) {
        // Check if exists to avoid duplicates
        $check = $pdo->prepare("SELECT id FROM products WHERE name = ?");
        $check->execute([$p['name']]);
        if ($check->rowCount() == 0) {
            $stmt->execute([$p['name'], $p['collection'], $p['price'], $p['description'], $p['image']]);
            echo "Inserted: " . $p['name'] . "<br>";
        } else {
            echo "Skipped (Already exists): " . $p['name'] . "<br>";
        }
    }
    echo "Done!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
