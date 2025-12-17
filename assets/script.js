// assets/script.js

// ==========================================
// GLOBAL STATE & API
// ==========================================
let products = [];
let cart = JSON.parse(localStorage.getItem('paradoxCart')) || [];
let currentFilter = 'all';

// Fetch products from the PHP backend
async function fetchProducts() {
    try {
        const response = await fetch('api/products.php');
        if (!response.ok) throw new Error('Network response was not ok');
        
        products = await response.json();
        console.log('Products loaded:', products.length);
        
        // Initialize UI components that depend on data
        if (document.getElementById('product-grid')) {
            renderProducts(currentFilter || 'all');
        }
        
        // Update cart UI to reflect current stock/prices
        updateCartUI();
        
    } catch (error) {
        console.error('Error fetching products:', error);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchProducts();
    updateCartUI();
    
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (nav) {
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        }
    });

    // Handle URL filters
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');
    if (filterParam) {
        setTimeout(() => {
            filterProducts(filterParam);
            const grid = document.getElementById('product-grid');
            if (grid) grid.scrollIntoView({ behavior: 'smooth' });
        }, 500);
    }
});

// ==========================================
// SCENT FINDER QUIZ (Restored "Old Look")
// ==========================================
// This uses the "How do you want to feel?" logic with the grid layout and icons.

let quizStep = 0;
let quizPreferences = [];
let quizModalInstance = null;

function startQuiz() {
    quizStep = 0;
    quizPreferences = [];
    const el = document.getElementById('quizModal');
    if (el) {
        quizModalInstance = new bootstrap.Modal(el);
        quizModalInstance.show();
        renderQuiz();
    }
}

function renderQuiz() {
    const content = document.getElementById('quiz-content');
    if (!content) return;
    
    content.innerHTML = ''; // Clear previous content

    if (quizStep === 0) {
        // STEP 1: How do you want to feel?
        content.innerHTML = `
            <div class="text-center animate-fade-in">
                <h3 class="display-6 font-serif mb-4 text-dark-text">How do you want to feel?</h3>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('floral')">
                            <span class="material-symbols-outlined fs-1 text-dusty-rose mb-2">favorite</span>
                            <div class="fw-bold">Romantic</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('citrus')">
                            <span class="material-symbols-outlined fs-1 text-warning mb-2">wb_sunny</span>
                            <div class="fw-bold">Energetic</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('aquatic')">
                            <span class="material-symbols-outlined fs-1 text-info mb-2">water_drop</span>
                            <div class="fw-bold">Fresh & Clean</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('power')">
                            <span class="material-symbols-outlined fs-1 text-dark mb-2">diamond</span>
                            <div class="fw-bold">Bold</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else if (quizStep === 1) {
        // STEP 2: Where are you going?
        content.innerHTML = `
            <div class="text-center animate-fade-in">
                <h3 class="display-6 font-serif mb-4 text-dark-text">Where are you going?</h3>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('floral')">
                            <span class="material-symbols-outlined fs-1 text-dusty-rose mb-2">local_bar</span>
                            <div class="fw-bold">Date Night</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('power')">
                            <span class="material-symbols-outlined fs-1 text-dark mb-2">work</span>
                            <div class="fw-bold">Office / Work</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('fruity')">
                            <span class="material-symbols-outlined fs-1 text-warning mb-2">celebration</span>
                            <div class="fw-bold">Party</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 border rounded cursor-pointer hover-shadow h-100 d-flex flex-column align-items-center justify-content-center" onclick="handleQuizOption('citrus')">
                            <span class="material-symbols-outlined fs-1 text-success mb-2">coffee</span>
                            <div class="fw-bold">Casual Day</div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        showResult();
    }
}

function handleQuizOption(vibe) {
    quizPreferences.push(vibe);
    quizStep++;
    renderQuiz();
}

function showResult() {
    const content = document.getElementById('quiz-content');
    
    // Logic: Find the most frequent vibe selected
    // If tie or empty, default to first preference or 'floral'
    let resultVibe = quizPreferences[0] || 'floral';
    
    // Simple frequency map
    const counts = {};
    quizPreferences.forEach(v => { counts[v] = (counts[v] || 0) + 1; });
    
    // Find max
    let maxCount = 0;
    for (const vibe in counts) {
        if (counts[vibe] > maxCount) {
            maxCount = counts[vibe];
            resultVibe = vibe;
        }
    }

    // Find a matching product from the DATABASE products
    // We look for a product where the collection matches the vibe
    const recommendation = products.find(p => p.collection === resultVibe) || products[0];

    if (!recommendation) {
        content.innerHTML = '<p class="text-center">No recommendation found.</p>';
        return;
    }

    let imgPath = recommendation.image_path;
    if (!imgPath.startsWith('assets/')) {
        imgPath = `assets/${imgPath}`;
    }

    content.innerHTML = `
        <div class="text-center animate-fade-in">
            <h3 class="display-6 font-serif mb-3 text-dark-text">We found your match!</h3>
            <div class="card border-0 shadow-sm mx-auto mt-3" style="max-width: 250px;">
                <img src="${imgPath}" class="card-img-top" alt="${recommendation.name}">
                <div class="card-body">
                    <h5 class="font-serif fw-bold">${recommendation.name}</h5>
                    <p class="text-muted small">${recommendation.description}</p>
                    <p class="fw-bold">₱${recommendation.price}</p>
                    <button class="btn btn-custom-dark w-100" onclick="addToCart(${recommendation.id}); quizModalInstance.hide();">Add to Bag</button>
                </div>
            </div>
            <button class="btn btn-link text-muted mt-3" onclick="startQuiz()">Retake Quiz</button>
        </div>
    `;
}


// ==========================================
// COLLECTIONS & FILTERING
// ==========================================

function renderProducts(filter) {
    const grid = document.getElementById('product-grid');
    if (!grid) return;
    
    grid.innerHTML = '';
    
    const filtered = filter === 'all' 
        ? products 
        : products.filter(p => p.collection === filter);

    // Update filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.filter === filter) btn.classList.add('active');
    });

    if (filtered.length === 0) {
        grid.innerHTML = '<div class="col-12 text-center py-5"><p class="text-muted">No perfumes found in this collection.</p></div>';
        return;
    }

    grid.innerHTML = filtered.map(p => {
        const isOutOfStock = p.stock_qty <= 0;
        let imgPath = p.image_path;
        if (!imgPath.startsWith('assets/')) imgPath = `assets/${imgPath}`;

        return `
        <div class="col-md-6 col-lg-4 col-xl-3 fade-in-up">
            <div class="product-card h-100">
                <div class="product-img-wrapper mb-3">
                    <img src="${imgPath}" alt="${p.name}" class="${isOutOfStock ? 'opacity-50' : ''}">
                    ${isOutOfStock 
                        ? '<div class="position-absolute top-50 start-50 translate-middle badge bg-dark text-white px-3 py-2">OUT OF STOCK</div>' 
                        : `<button onclick="addToCart(${p.id})" class="add-to-cart-btn"><span class="material-symbols-outlined">add_shopping_cart</span></button>`
                    }
                </div>
                <div class="text-center">
                    <h4 class="font-serif fw-bold h5 text-dark-text mb-1">${p.name}</h4>
                    <p class="small text-secondary px-2">${p.description}</p>
                    <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                        <span class="fw-bold text-dark-text">₱${p.price}</span>
                        <span class="badge bg-light text-dark border ${p.stock_qty < 5 ? 'text-danger border-danger' : ''}">
                            ${isOutOfStock ? 'Sold Out' : 'Stock: ' + p.stock_qty}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `}).join('');
}

function filterProducts(category) {
    currentFilter = category;
    renderProducts(category);
}

// ==========================================
// CART LOGIC
// ==========================================

function addToCart(id) {
    const product = products.find(p => p.id == id);
    if (!product) return;

    if (product.stock_qty <= 0) {
        showToast('Sorry, this item is out of stock');
        return;
    }

    const existingItem = cart.find(item => item.id == id);
    if (existingItem) {
        if (existingItem.qty + 1 > product.stock_qty) {
            showToast(`Only ${product.stock_qty} items available`);
            return;
        }
        existingItem.qty++;
    } else {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image_path: product.image_path,
            qty: 1
        });
    }

    saveCart();
    updateCartUI();
    showToast('Added to bag');
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id != id);
    saveCart();
    updateCartUI();
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.id == id);
    const product = products.find(p => p.id == id);
    
    if (item && product) {
        const newQty = item.qty + change;
        if (newQty > product.stock_qty) {
            showToast(`Only ${product.stock_qty} items available`);
            return;
        }
        item.qty = newQty;
        if (item.qty <= 0) removeFromCart(id);
        else {
            saveCart();
            updateCartUI();
        }
    }
}

function saveCart() {
    localStorage.setItem('paradoxCart', JSON.stringify(cart));
}

function updateCartUI() {
    const countEl = document.getElementById('cart-count');
    const itemsContainer = document.getElementById('cart-items');
    const totalEl = document.getElementById('cart-total');
    
    if (countEl) {
        const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
        countEl.innerText = totalQty;
        
        // Toggle the 'show' class based on quantity
        if (totalQty > 0) {
            countEl.classList.add('show');
        } else {
            countEl.classList.remove('show');
        }
    }

    let hasStockIssue = false;

    if (itemsContainer) {
        if (cart.length === 0) {
            itemsContainer.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                    <span class="material-symbols-outlined fs-1 mb-3">shopping_bag</span>
                    <p>Your bag is empty.</p>
                    <button class="btn btn-link text-dusty-rose fw-bold text-decoration-none" data-bs-dismiss="offcanvas" onclick="window.location.href='collections.html'">Start Shopping</button>
                </div>
            `;
        } else {
            itemsContainer.innerHTML = cart.map(item => {
                const product = products.find(p => p.id == item.id);
                let imagePath = product ? product.image_path : item.image_path;
                let imgSrc = imagePath || 'assets/Images/placeholder.webp';
                if (!imgSrc.startsWith('assets/')) imgSrc = `assets/${imgSrc}`;
                
                const stock = product ? product.stock_qty : 999; 
                const isIssue = product ? (item.qty > stock) : false;
                if (isIssue) hasStockIssue = true;

                return `
                <div class="d-flex gap-3 mb-3 align-items-center ${isIssue ? 'bg-danger-subtle p-2 rounded' : ''}">
                    <img src="${imgSrc}" class="rounded object-fit-cover" style="width: 50px; height: 50px;">
                    <div class="flex-grow-1">
                        <h6 class="mb-0 font-serif text-dark-text small fw-bold">${item.name}</h6>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="updateQuantity(${item.id}, -1)">-</button>
                            <span class="small">${item.qty}</span>
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="updateQuantity(${item.id}, 1)" ${product && item.qty >= stock ? 'disabled' : ''}>+</button>
                        </div>
                        ${isIssue ? `<div class="text-danger x-small fw-bold mt-1">Only ${stock} left! Reduce qty.</div>` : ''}
                    </div>
                    <div class="text-end">
                        <div class="fw-bold small">₱${(item.price * item.qty).toFixed(2)}</div>
                        <button class="btn btn-link text-danger p-0 small text-decoration-none" onclick="removeFromCart(${item.id})">Remove</button>
                    </div>
                </div>
            `}).join('');
        }
    }

    if (totalEl) {
        const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        totalEl.innerText = `₱${total.toFixed(2)}`;
    }

    const checkoutBtn = document.querySelector('button[onclick*="checkout.html"]');
    if (checkoutBtn) {
        if (hasStockIssue || cart.length === 0) {
            checkoutBtn.disabled = true;
            checkoutBtn.innerText = hasStockIssue ? "Adjust Quantity" : "Checkout";
        } else {
            checkoutBtn.disabled = false;
            checkoutBtn.innerText = "Checkout";
        }
    }
}

function showToast(message) {
    const toastEl = document.getElementById('liveToast');
    const msgEl = document.getElementById('toast-message');
    if (toastEl && msgEl) {
        msgEl.innerText = message;
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
}
