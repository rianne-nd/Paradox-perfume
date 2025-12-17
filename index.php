<?php
require_once 'api/db.php';

// Fetch all active products
try {
    $stmt = $pdo->query("SELECT * FROM products WHERE is_active = 1");
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
    // In production, log error
}

// Helper to filter products by collection
function getProductsByCollection($products, $collection) {
    return array_filter($products, function($p) use ($collection) {
        return $p['collection'] === $collection;
    });
}

function renderProductCards($products) {
    if (empty($products)) {
        echo '<div class="col-12 text-center"><p class="text-muted">No products found in this collection.</p></div>';
        return;
    }
    foreach ($products as $p) {
        $isOutOfStock = $p['stock_qty'] <= 0;
        $imgPath = $p['image_path'];
        if (strpos($imgPath, 'assets/') !== 0) {
            $imgPath = 'assets/' . $imgPath;
        }
        
        $opacityClass = $isOutOfStock ? 'opacity-50' : '';
        $badgeOrBtn = $isOutOfStock 
            ? '<div class="position-absolute top-50 start-50 translate-middle badge bg-dark text-white px-3 py-2">OUT OF STOCK</div>' 
            : '<button onclick="addToCart(' . $p['id'] . ')" class="add-to-cart-btn"><span class="material-symbols-outlined">add_shopping_cart</span></button>';
            
        echo '
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="product-card h-100">
                <div class="product-img-wrapper mb-3">
                    <img src="' . htmlspecialchars($imgPath) . '" alt="' . htmlspecialchars($p['name']) . '" class="' . $opacityClass . '">
                    ' . $badgeOrBtn . '
                </div>
                <div class="text-center">
                    <h4 class="font-serif fw-bold h5 text-dark-text mb-1">' . htmlspecialchars($p['name']) . '</h4>
                    <p class="small text-secondary px-2">' . htmlspecialchars($p['description']) . '</p>
                </div>
            </div>
        </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- 
        LEARNING NOTE: Meta Tags
        - charset="utf-8": Ensures the browser can display all characters (including emojis!).
        - viewport: CRITICAL for mobile responsiveness. It tells the browser to set the width 
          of the page to the width of the device's screen. Without this, mobile phones 
          would zoom out to show the whole desktop site, making text tiny.
    -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradox Manila | Unlock Your Signature Scent</title>
    
    <!-- 
        LEARNING NOTE: External Resources (CDN)
        - We are linking to files hosted on other servers (CDNs - Content Delivery Networks).
        - This loads Bootstrap (CSS framework) and Google Fonts without downloading them locally.
        - rel="stylesheet": Tells the browser this file contains style rules.
    -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&amp;family=Lato:wght@300;400;700&amp;display=swap" rel="stylesheet">
    
    <!-- Custom CSS: Our own styles to override Bootstrap and add unique branding -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- Navigation -->
<!-- 
    LEARNING NOTE: Bootstrap Navbar
    - <nav>: Semantic HTML tag for navigation links.
    - .navbar-expand-lg: This class tells the navbar to show full links on Large screens (lg),
      but collapse into a "hamburger menu" on smaller screens.
    - .fixed-top: Uses CSS 'position: fixed' to stick the navbar to the top of the viewport.
-->
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container-fluid px-lg-5">
        <!-- Brand Logo -->
        <a class="navbar-brand font-serif fw-bold fs-3 text-dark-text d-flex align-items-center gap-2" href="index.php">
            <img src="assets/Images/ParadoxLogo.webp" alt="Paradox Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            <span>Paradox <span class="fw-normal fst-italic fs-4">Manila</span></span>
        </a>
        
        <div class="d-flex align-items-center gap-3 order-lg-3">
            <!-- Cart Button: Toggles the offcanvas cart drawer -->
            <button class="btn btn-link text-dark-text p-2 position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
                <span class="material-symbols-outlined fs-3">shopping_bag</span>
                <span id="cart-count">0</span>
            </button>
            <!-- Mobile Toggle: Hamburger menu button for mobile view -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="material-symbols-outlined fs-2">menu</span>
            </button>
        </div>

        <!-- Collapsible Menu Items -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-4">
                <li class="nav-item"><a class="nav-link" href="collections.html">Collections</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#about">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.html">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#" onclick="startQuiz(); return false;">Scent Finder</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content Area: Wraps all page content -->
<main id="main-content">
    
    <!-- HOME PAGE VIEW: The default view when landing on the site -->
    <div id="home-view">
        <!-- 
            Hero Section: 
            - The large banner at the top.
            - Contains the background image, overlay for text readability, and CTA buttons.
        -->
                <!-- 
            Hero Section: 
            - The large banner at the top.
            - Contains the background image, overlay for text readability, and CTA buttons.
            - LEARNING NOTE: We use 'position: relative' on the parent so we can use 'position: absolute'
              on the children (bg and overlay) to stack them on top of each other.
        -->
        <header class="hero-section">
            <div class="hero-bg">
                <img src="assets/Images/bg pictures/paradox_1.webp" alt="Paradox Manila Hero">
            </div>
            <!-- Overlay: A semi-transparent layer to make text readable against the image -->
            <div class="hero-overlay"></div>
            
            <!-- 
                z-10: A utility class (or custom style) to ensure the text sits ON TOP of the overlay.
                container: Centers the content and gives it max-width.
            -->
            <div class="container position-relative z-10">
                <div class="row">
                    <div class="col-lg-8 ps-lg-5 hero-content">
                        <p class="text-uppercase text-secondary fw-semibold ls-2 mb-3 fade-in-up" style="letter-spacing: 0.2em;">The Essence of Accessible Luxury</p>
                        <h1 class="display-1 fw-medium text-dark-text mb-4 fade-in-up" style="animation-delay: 0.1s;">
                            Unlock Your <br><span class="fst-italic text-gold-accent">Signature Scent</span>
                        </h1>
                        <p class="lead text-secondary mb-5 fw-light fade-in-up" style="animation-delay: 0.2s; max-width: 500px;">
                            Handcrafted fragrances inspired by the world's most iconic scents. 
                            Experience 30% oil concentration for a lasting impression.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3 fade-in-up" style="animation-delay: 0.3s;">
                            <button class="btn btn-custom-dark" onclick="document.getElementById('featured-sections').scrollIntoView({behavior: 'smooth'})">
                                See Featured Scents
                            </button>
                            <button class="btn btn-custom-outline d-flex align-items-center justify-content-center gap-2" onclick="startQuiz()">
                                <span class="material-symbols-outlined">psychology</span>
                                Find My Vibe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- 
            FEATURED SECTIONS:
            - These containers (id="featured-floral", etc.) are empty in HTML.
            - They are populated by JavaScript (script.js) which injects the product cards.
        -->
        <div id="featured-sections">
            <!-- Header for Featured -->
            <div class="py-5 text-center" style="background-color: #FFF5F5;">
                <h2 class="display-5 font-serif text-dark-text">Featured Collections</h2>
                <div class="mx-auto mt-3 opacity-25 bg-dark" style="height: 2px; width: 100px;"></div>
            </div>

            <!-- FLORAL SECTION -->
            <section class="py-5 bg-floral">
                <div class="container">
                    <div class="text-center mb-5">
                        <h3 class="h2 font-serif text-uppercase text-dark-text mb-2">The Floral Reverie Collection</h3>
                        <p class="text-secondary fst-italic font-serif">Soft, romantic, and feminine scents inspired by nature in bloom.</p>
                    </div>
                    <div class="row g-4" id="featured-floral"><?php renderProductCards(getProductsByCollection($products, 'floral')); ?></div>
                </div>
            </section>

            <!-- CITRUS SECTION -->
            <section class="py-5 bg-citrus">
                <div class="container">
                    <div class="text-center mb-5">
                        <h3 class="h2 font-serif text-uppercase text-dark-text mb-2">Citrus Collection — Sunlit Essence</h3>
                        <p class="text-secondary fst-italic font-serif">Bright notes that bring energy, freshness, and the warmth of summer mornings.</p>
                    </div>
                    <div class="row g-4 justify-content-center" id="featured-citrus"><?php renderProductCards(getProductsByCollection($products, 'citrus')); ?></div>
                </div>
            </section>

            <!-- FRUITY SECTION -->
            <section class="py-5 bg-fruity">
                <div class="container">
                    <div class="text-center mb-5">
                        <h3 class="h2 font-serif text-uppercase text-dark-text mb-2">Fruity & Unique Scents — The Juicy Botanicals</h3>
                        <p class="text-secondary fst-italic font-serif">Fresh, lively scents with crisp fruits, honeyed sweetness, and playful charm.</p>
                    </div>
                    <div class="row g-4 justify-content-center" id="featured-fruity"><?php renderProductCards(getProductsByCollection($products, 'fruity')); ?></div>
                </div>
            </section>
            
            <!-- POWER SECTION -->
            <section class="py-5 bg-power">
                <div class="container">
                    <div class="text-center mb-5">
                        <h3 class="h2 font-serif text-uppercase text-dark-text mb-2">Aromatic / Sweet Boldness</h3>
                        <p class="text-secondary fst-italic font-serif">Bold, sweet, and warm scents with depth and power.</p>
                    </div>
                    <div class="row g-4 justify-content-center" id="featured-power"><?php renderProductCards(getProductsByCollection($products, 'power')); ?></div>
                </div>
            </section>

            <!-- AQUATIC SECTION -->
            <section class="py-5 bg-aquatic">
                <div class="container">
                    <div class="text-center mb-5">
                        <h3 class="h2 font-serif text-uppercase text-dark-text mb-2">Fresh & Aquatic Collection</h3>
                        <p class="text-secondary fst-italic font-serif">Clean, airy scents inspired by ocean breezes and everyday freshness.</p>
                    </div>
                    <div class="row g-4 justify-content-center" id="featured-aquatic"><?php renderProductCards(getProductsByCollection($products, 'aquatic')); ?></div>
                </div>
            </section>
        </div>

        <!-- About Section -->
        <section class="py-5 position-relative overflow-hidden" id="about" style="background-color: rgba(243, 229, 220, 0.3);">
            <div class="container py-5">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-6 position-relative">
                        <div class="rounded-top-circle overflow-hidden shadow-lg" style="border-top-left-radius: 50%; border-top-right-radius: 50%;">
                            <img alt="About Paradox" class="img-fluid w-100" src="assets/Images/Picture Perfumes/The essence of Paradox.webp">
                        </div>
                    </div>
                    <div class="col-lg-6 text-center text-lg-start">
                        <h2 class="display-4 font-serif mb-4">The Essence of <br><span class="fst-italic text-dusty-rose">Paradox</span></h2>
                        <div class="lead fw-light text-secondary mb-4">
                            <p>
                                We believe in democratized beauty. <strong>Paradox Manila</strong> was born from the idea that luxury shouldn't be gated by price. 
                                We craft scents that mirror the complexity of high-end perfumery, bottled for the everyday dreamer.
                            </p>
                        </div>
                        <div class="row g-4 mt-2">
                            <div class="col-md-6">
                                <div class="bg-white p-4 rounded shadow-sm h-100">
                                    <span class="material-symbols-outlined fs-2 text-success mb-2">spa</span>
                                    <h4 class="font-serif fw-bold h5 mb-2">30% Oil Concentration</h4>
                                    <p class="small text-muted mb-0">Longer lasting scents that stay with you from morning mist to evening glow.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white p-4 rounded shadow-sm h-100">
                                    <span class="material-symbols-outlined fs-2 text-dusty-rose mb-2">favorite</span>
                                    <h4 class="font-serif fw-bold h5 mb-2">Accessible Luxury</h4>
                                    <p class="small text-muted mb-0">Premium ingredients and glass packaging at a price that makes sense.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</main>

<!-- Footer -->
<footer class="bg-light border-top pt-5 pb-4">
    <div class="container">
        <div class="row gy-5 mb-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img src="assets/Images/ParadoxLogo.webp" alt="Paradox Logo" class="rounded-circle border border-secondary" style="width: 40px; height: 40px; object-fit: cover;">
                    <span class="h5 font-serif text-dark-text mb-0">Paradox Manila</span>
                </div>
                <p class="text-secondary small mb-4" style="max-width: 300px;">
                    Crafting accessible luxury through scents that inspire, comfort, and define you.
                </p>
                <div class="d-flex gap-3">
                    <a href="http://facebook.com/profile.php?id=100063545048923" target="_blank" class="text-decoration-none">
                        <img src="assets/Images/FacebookLogo.webp" alt="Facebook" style="width: 24px; height: 24px;">
                    </a>
                    <a href="https://www.instagram.com/paradox_mnl/" target="_blank" class="text-decoration-none">
                        <img src="assets/Images/InstagramLogo.webp" alt="Instagram" style="width: 24px; height: 24px;">
                    </a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-2">
                <h4 class="font-serif h6 mb-3 text-dark-text">Shop</h4>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><a href="collections.html" class="text-decoration-none text-secondary">All Perfumes</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h4 class="font-serif h6 mb-3 text-dark-text">Company</h4>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><a href="index.php#about" class="text-decoration-none text-secondary">About Us</a></li>
                    <li class="mb-2"><a href="#" class="text-decoration-none text-secondary">Contact Us</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h4 class="font-serif h6 mb-3 text-dark-text">Help</h4>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-2"><a href="faq.html" class="text-decoration-none text-secondary">FAQ</a></li>
                </ul>
            </div>
        </div>
        <div class="border-top pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted">
            <div class="mb-2 mb-md-0">Tondo, Manila</div>
            <div>&copy; 2025 Paradox MNL. All Rights Reserved.</div>
        </div>
    </div>
</footer>

<!-- Shopping Cart Offcanvas (Bootstrap) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartDrawer" aria-labelledby="cartDrawerLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title font-serif" id="cartDrawerLabel">Your Bag</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column" id="cart-items">
        <!-- Cart items go here -->
        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted" id="empty-cart-msg">
            <span class="material-symbols-outlined fs-1 mb-3">shopping_bag</span>
            <p>Your bag is empty.</p>
            <button class="btn btn-link text-dusty-rose fw-bold text-decoration-none" data-bs-dismiss="offcanvas" onclick="window.location.href='collections.html'">Start Shopping</button>
        </div>
    </div>
    <div class="p-3 border-top bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3 fw-bold">
            <span>Total</span>
            <span id="cart-total">₱0.00</span>
        </div>
        <button class="btn btn-custom-dark w-100" onclick="window.location.href='checkout.html'">Checkout</button>
    </div>
</div>

<!-- Toast Notification (Bootstrap) -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <span class="material-symbols-outlined text-success">check_circle</span>
                <span id="toast-message">Added to cart</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- Scent Finder Modal (Bootstrap) -->
<div class="modal fade" id="quizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5" id="quiz-content">
                <!-- Content injected by JS -->
            </div>
        </div>
    </div>
</div>

<!-- 
    Scripts:
    - Bootstrap Bundle: Includes Popper.js for tooltips/popovers.
    - script.js: Contains all the custom logic for the site (cart, products, quiz).
-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="assets/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
