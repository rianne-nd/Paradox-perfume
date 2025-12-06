// Data
const products = [
    // Floral Reverie
    { id: 1, name: "Burberry Women", collection: "floral", price: 150, description: "A classic, elegant scent for the modern woman.", image: "Images/THE FLORAL REVERIE COLLECTION/Burberry Women.jpg" },
    { id: 2, name: "Omnia Amethyste", collection: "floral", price: 150, description: "A powdery floral scent inspired by shimmering hues of amethyst gemstones.", image: "Images/THE FLORAL REVERIE COLLECTION/Omnia Amethyste.jpg" },
    { id: 3, name: "Eclat D’Arpege", collection: "floral", price: 150, description: "A delicate, fruity floral fragrance. Soft and romantic.", image: "Images/THE FLORAL REVERIE COLLECTION/Eclat D’Arpege.jpg" },
    { id: 4, name: "Eternity (Women)", collection: "floral", price: 150, description: "A timeless blend of white flowers and soft woods.", image: "Images/THE FLORAL REVERIE COLLECTION/Eternity (Women).jpg" },
    
    // Sunlit Essence (Citrus)
    { id: 5, name: "Light Blue", collection: "citrus", price: 150, description: "Zesty, vibrant, and full of life. Captures the essence of a sunny day.", image: "Images/CITRUS COLLECTION — THE SUNLIT ESSENCE/Light Blue.png" },
    { id: 6, name: "Happy (Men & Women)", collection: "citrus", price: 150, description: "Pure joy in a bottle. A hint of citrus, a wealth of flowers.", image: "Images/CITRUS COLLECTION — THE SUNLIT ESSENCE/Happy (Men & Women).png" },
    { id: 7, name: "Cold", collection: "citrus", price: 150, description: "Crisp, cooling citrus. Refreshing and energizing.", image: "Images/CITRUS COLLECTION — THE SUNLIT ESSENCE/Cold.png" },

    // Fruity & Unique Scents
    { id: 13, name: "English Pear & Freesia", collection: "fruity", price: 150, description: "Crisp, elegant fruit paired with subtle floral notes. (Inspired by Jo Malone)", image: "Images/FRUITY & UNIQUE SCENTS — THE JUICY BOTANICALS/English Pear & Freesia.png" },
    { id: 14, name: "Nectarine Blossom & Honey", collection: "fruity", price: 150, description: "Juicy, luscious sweetness and honeyed delight. (Inspired by Jo Malone)", image: "Images/FRUITY & UNIQUE SCENTS — THE JUICY BOTANICALS/Nectarine Blossom & Honey.png" },

    // Ocean Air (Aquatic)
    { id: 8, name: "Cool Water", collection: "aquatic", price: 150, description: "The essence of ocean freshness. Crisp, clean, and refreshing.", image: "Images/FRESH & AQUATIC COLLECTION — THE OCEAN AIR/Cool Water (Men & Women).png.png" },
    { id: 9, name: "Aqva Pour Homme", collection: "aquatic", price: 150, description: "Noble and masculine, evoking the power and beauty of the sea.", image: "Images/FRESH & AQUATIC COLLECTION — THE OCEAN AIR/Aqva Pour Homme.png" },

    // Power Series (Aromatic/Woody)
    { id: 10, name: "Eros", collection: "power", price: 150, description: "Love, passion, beauty, and desire. A unique aura of sensuality.", image: "Images/AROMATIC  SWEET BOLDNESS — THE POWER SERIES/Eros.png" },
    { id: 11, name: "Vanilla & Anise", collection: "power", price: 150, description: "A modern story of vanilla. The fragile vanilla orchid, perfect in its detail.", image: "Images/AROMATIC  SWEET BOLDNESS — THE POWER SERIES/Vanilla & Anise.png" },
    { id: 12, name: "Eternity (Men)", collection: "power", price: 150, description: "Distinctive. Romantic. Timeless. A classic fougère scent.", image: "Images/AROMATIC  SWEET BOLDNESS — THE POWER SERIES/Eternity (Men).png" }
];

let cart = JSON.parse(localStorage.getItem('paradoxCart')) || [];
let currentFilter = 'all';

// Initialization
document.addEventListener('DOMContentLoaded', () => {
    renderProducts('all');
    renderFeaturedSections();
    updateCartUI();
    
    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (nav) {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        }
    });

    // Check for filter in URL (for cross-page navigation)
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');
    if (filterParam) {
        filterProducts(filterParam);
        // Scroll to grid if on collections page
        const grid = document.getElementById('product-grid');
        if (grid) {
            grid.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

// Render Featured Sections
function renderFeaturedSections() {
    const renderCards = (items, containerId) => {
        const container = document.getElementById(containerId);
        if(!container) return;
        container.innerHTML = items.map(p => {
            const imgUrl = p.image;
            return `
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="product-card h-100">
                        <div class="product-img-wrapper mb-3">
                            <img src="${imgUrl}" alt="${p.name}">
                            <button onclick="addToCart(${p.id})" class="add-to-cart-btn">
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                            </button>
                        </div>
                        <div class="text-center">
                            <h4 class="font-serif fw-bold h5 text-dark-text mb-1">${p.name}</h4>
                            <p class="small text-secondary px-2">${p.description}</p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    };

    renderCards(products.filter(p => p.collection === 'floral'), 'featured-floral');
    renderCards(products.filter(p => p.collection === 'citrus'), 'featured-citrus');
    renderCards(products.filter(p => p.collection === 'fruity'), 'featured-fruity');
    renderCards(products.filter(p => p.collection === 'power'), 'featured-power');
    renderCards(products.filter(p => p.collection === 'aquatic'), 'featured-aquatic');
}

// Render Collections
function renderProducts(filter) {
    const grid = document.getElementById('product-grid');
    if (!grid) return;
    
    grid.innerHTML = '';

    const filtered = filter === 'all' ? products : products.filter(p => p.collection === filter);

    filtered.forEach((p, index) => {
        const delay = index * 50;
        const imgUrl = p.image;

        const col = document.createElement('div');
        col.className = 'col-sm-6 col-lg-4 col-xl-3 fade-in-up';
        col.style.animationDelay = `${delay}ms`;

        col.innerHTML = `
            <div class="card h-100 border-0 shadow-sm product-card bg-white">
                <div class="position-relative overflow-hidden bg-light d-flex align-items-center justify-content-center" style="aspect-ratio: 1/1;">
                    <img src="${imgUrl}" alt="${p.name}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.7s;">
                    <div class="bottle-label">
                        <span>Paradox</span>
                        <h4>${p.name}</h4>
                        <span>Eau de Parfum</span>
                    </div>
                    <button onclick="addToCart(${p.id})" class="add-to-cart-btn">
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                    </button>
                </div>
                <div class="card-body text-center p-4">
                    <div class="small fw-bold text-muted text-uppercase ls-1 mb-1">${p.collection} collection</div>
                    <h3 class="h5 font-serif fw-bold text-dark-text mb-2">${p.name}</h3>
                    <p class="small text-secondary mb-3 text-truncate">${p.description}</p>
                    <div class="h5 fw-bold text-dusty-rose">₱${p.price}</div>
                </div>
            </div>
        `;
        grid.appendChild(col);
    });
}

// Filtering
function filterProducts(category) {
    currentFilter = category;
    const tabs = document.querySelectorAll('.tab-btn');
    if (tabs.length > 0) {
        tabs.forEach(tab => {
            if (tab.innerText.toLowerCase().includes(category === 'all' ? 'all' : category)) {
                tab.classList.add('active', 'btn-outline-dark');
                tab.classList.remove('btn-outline-secondary');
            } else {
                tab.classList.remove('active', 'btn-outline-dark');
                tab.classList.add('btn-outline-secondary');
            }
        });
    }
    renderProducts(category);
}

// Cart Logic
function addToCart(id) {
    const product = products.find(p => p.id === id);
    const existing = cart.find(item => item.id === id);

    if (existing) {
        existing.qty++;
    } else {
        cart.push({ ...product, qty: 1 });
    }

    saveCart();
    updateCartUI();
    showToast(`Added ${product.name} to bag`);
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    saveCart();
    updateCartUI();
}

function saveCart() {
    localStorage.setItem('paradoxCart', JSON.stringify(cart));
}

function updateCartUI() {
    const container = document.getElementById('cart-items');
    const countBadge = document.getElementById('cart-count');
    const totalEl = document.getElementById('cart-total');

    const totalQty = cart.reduce((acc, item) => acc + item.qty, 0);
    
    if (countBadge) {
        countBadge.innerText = totalQty;
        countBadge.classList.toggle('show', totalQty > 0);
    }

    if (!container || !totalEl) return;

    if (cart.length === 0) {
        container.innerHTML = `
            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted" id="empty-cart-msg">
                <span class="material-symbols-outlined fs-1 mb-3">shopping_bag</span>
                <p>Your bag is empty.</p>
                <button class="btn btn-link text-dusty-rose fw-bold text-decoration-none" data-bs-dismiss="offcanvas" onclick="window.location.href='collections.html'">Start Shopping</button>
            </div>
        `;
        totalEl.innerText = '₱0.00';
        return;
    }
    
    container.innerHTML = cart.map(item => `
        <div class="d-flex gap-3 align-items-center mb-3">
            <div class="rounded bg-light flex-shrink-0" style="width: 64px; height: 64px; overflow: hidden;">
                <img src="${item.image}" class="w-100 h-100 object-fit-cover">
            </div>
            <div class="flex-grow-1">
                <h6 class="font-serif fw-bold mb-0 small">${item.name}</h6>
                <p class="text-muted small mb-0">₱${item.price} x ${item.qty}</p>
            </div>
            <button onclick="removeFromCart(${item.id})" class="btn btn-link text-secondary p-0">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </div>
    `).join('');

    const total = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
    totalEl.innerText = `₱${total.toFixed(2)}`;
}

function showToast(msg) {
    const toastEl = document.getElementById('liveToast');
    const msgEl = document.getElementById('toast-message');
    if (!toastEl || !msgEl) return;
    
    msgEl.innerText = msg;
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

// Quiz Logic
let quizModal;
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('quizModal');
    if (el) {
        quizModal = new bootstrap.Modal(el);
    }
});

function startQuiz() {
    if (!quizModal) return;
    const content = document.getElementById('quiz-content');
    content.innerHTML = `
        <div id="q1" class="text-center">
            <h3 class="display-6 font-serif mb-4 text-dark-text">How do you want to feel?</h3>
            <div class="row g-3">
                <div class="col-6">
                    <button onclick="nextStep(1, 'Romantic')" class="btn btn-outline-light text-dark border w-100 p-4 h-100 hover-shadow">
                        <span class="material-symbols-outlined fs-1 mb-2 text-dusty-rose">favorite</span>
                        <div class="fw-bold">Romantic</div>
                    </button>
                </div>
                <div class="col-6">
                    <button onclick="nextStep(1, 'Energetic')" class="btn btn-outline-light text-dark border w-100 p-4 h-100 hover-shadow">
                        <span class="material-symbols-outlined fs-1 mb-2 text-warning">wb_sunny</span>
                        <div class="fw-bold">Energetic</div>
                    </button>
                </div>
                <div class="col-6">
                    <button onclick="nextStep(1, 'Clean')" class="btn btn-outline-light text-dark border w-100 p-4 h-100 hover-shadow">
                        <span class="material-symbols-outlined fs-1 mb-2 text-info">water_drop</span>
                        <div class="fw-bold">Fresh & Clean</div>
                    </button>
                </div>
                <div class="col-6">
                    <button onclick="nextStep(1, 'Bold')" class="btn btn-outline-light text-dark border w-100 p-4 h-100 hover-shadow">
                        <span class="material-symbols-outlined fs-1 mb-2 text-dark">diamond</span>
                        <div class="fw-bold">Bold & Powerful</div>
                    </button>
                </div>
            </div>
        </div>
    `;
    quizModal.show();
}

function nextStep(current, choice) {
    const content = document.getElementById('quiz-content');
    let recommendedFilter = 'all';
    let recommendedText = '';

    if (choice === 'Romantic') { recommendedFilter = 'floral'; recommendedText = 'Floral Reverie'; }
    else if (choice === 'Energetic') { recommendedFilter = 'citrus'; recommendedText = 'Sunlit Essence'; }
    else if (choice === 'Clean') { recommendedFilter = 'aquatic'; recommendedText = 'Ocean Air'; }
    else { recommendedFilter = 'power'; recommendedText = 'Power Series'; }

    content.innerHTML = `
        <div class="text-center">
            <span class="material-symbols-outlined display-1 text-dusty-rose mb-3">auto_awesome</span>
            <h3 class="display-6 font-serif mb-3">We found your match!</h3>
            <p class="text-secondary mb-4">Based on your vibe, we recommend the <strong>${recommendedText}</strong> collection.</p>
            <div class="d-flex gap-3 justify-content-center">
                <button onclick="startQuiz()" class="btn btn-outline-dark rounded-pill px-4">
                    Redo Test
                </button>
                <button onclick="finishQuiz('${recommendedFilter}')" class="btn btn-custom-dark rounded-pill px-4">
                    Shop Collection
                </button>
            </div>
        </div>
    `;
}

function finishQuiz(filter) {
    if (quizModal) quizModal.hide();
    
    // Check if we are on collections page or home page where featured sections exist
    const targetId = `featured-${filter}`;
    const target = document.getElementById(targetId);
    
    if(target) {
        target.scrollIntoView({behavior: 'smooth'});
    } else {
        // Redirect to collections page with filter
        window.location.href = `collections.html?filter=${filter}`;
    }
}

/* -------------------------------------------------------------------------- */
/* GITHUB SYNC LOGIC                                 */
/* -------------------------------------------------------------------------- */
let ghModal;
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('githubModal');
    if (el) {
        ghModal = new bootstrap.Modal(el);
    }
});

function openGithubModal() {
    if (ghModal) ghModal.show();
}

function closeGithubModal() {
    if (ghModal) ghModal.hide();
}

// Utility to log messages
function ghLog(msg, type='info') {
    const logEl = document.getElementById('gh-log');
    if (!logEl) return;
    logEl.classList.remove('d-none');
    const color = type === 'error' ? 'text-danger' : 'text-muted';
    const icon = type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info');
    
    const line = document.createElement('div');
    line.className = `d-flex gap-2 align-items-center ${color} mb-1`;
    line.innerHTML = `<span class="material-symbols-outlined" style="font-size: 14px;">${icon}</span> <span>${msg}</span>`;
    
    logEl.appendChild(line);
    logEl.scrollTop = logEl.scrollHeight;
}

// Prepare the GitHub Actions Workflow content
const githubWorkflowYaml = `name: Deploy static content to Pages

on:
  push:
    branches: ["main"]
  workflow_dispatch:

permissions:
  contents: read
  pages: write
  id-token: write

concurrency:
  group: "pages"
  cancel-in-progress: false

jobs:
  deploy:
    environment:
      name: github-pages
      url: \${{ steps.deployment.outputs.page_url }}
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v4
      - name: Setup Pages
        uses: actions/configure-pages@v5
      - name: Upload artifact
        uses: actions/upload-pages-artifact@v3
        with:
          path: '.'
      - name: Deploy to GitHub Pages
        id: deployment
        uses: actions/deploy-pages@v4`;

// Function to clean HTML for export
function getCleanHTML() {
    const clone = document.documentElement.cloneNode(true);
    const ghModal = clone.querySelector('#githubModal');
    if (ghModal) ghModal.remove();

    const cartDrawer = clone.querySelector('#cartDrawer');
    if (cartDrawer) {
        cartDrawer.classList.remove('show');
        cartDrawer.removeAttribute('aria-modal');
        cartDrawer.removeAttribute('role');
    }
    
    const backdrops = clone.querySelectorAll('.modal-backdrop');
    backdrops.forEach(b => b.remove());

    const inputs = clone.querySelectorAll('input');
    inputs.forEach(input => input.setAttribute('value', ''));

    return "<!DOCTYPE html>\n" + clone.outerHTML;
}

async function syncToGitHub() {
    const username = document.getElementById('gh-username').value.trim();
    const repo = document.getElementById('gh-repo').value.trim();
    const token = document.getElementById('gh-token').value.trim();
    const btn = document.getElementById('gh-sync-btn');
    const logEl = document.getElementById('gh-log');

    if (!username || !repo || !token) {
        alert("Please fill in all GitHub details.");
        return;
    }

    logEl.innerHTML = '';
    btn.disabled = true;
    btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Syncing...`;

    try {
        ghLog(`Checking repository '${repo}'...`);
        let repoExists = false;
        
        const checkRes = await fetch(`https://api.github.com/repos/${username}/${repo}`, {
            headers: { 'Authorization': `token ${token}` }
        });

        if (checkRes.status === 404) {
            ghLog("Repo not found. Creating...", 'info');
            const createRes = await fetch('https://api.github.com/user/repos', {
                method: 'POST',
                headers: { 
                    'Authorization': `token ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: repo,
                    description: 'Paradox Manila Website - Auto-generated',
                    auto_init: true
                })
            });
            if (!createRes.ok) throw new Error('Failed to create repo');
            ghLog("Repository created successfully.", 'success');
            await new Promise(r => setTimeout(r, 2000));
        } else if (checkRes.ok) {
            repoExists = true;
            ghLog("Repository exists. Using it.", 'info');
        } else {
            throw new Error('Error checking repository');
        }

        const filesToUpload = [
            {
                path: 'index.html',
                content: btoa(unescape(encodeURIComponent(getCleanHTML()))),
                message: 'Update website content'
            },
            {
                path: '.github/workflows/static.yml',
                content: btoa(githubWorkflowYaml),
                message: 'Add GitHub Pages workflow'
            },
            {
                path: 'README.md',
                content: btoa(`# Paradox Manila\n\nGenerated website project. \n\n## Deployment\nThis project is configured to deploy to GitHub Pages automatically via Actions. check the 'Actions' tab.`),
                message: 'Add README'
            }
        ];

        for (const file of filesToUpload) {
            ghLog(`Uploading ${file.path}...`);
            
            let sha = null;
            const fileCheck = await fetch(`https://api.github.com/repos/${username}/${repo}/contents/${file.path}`, {
                headers: { 'Authorization': `token ${token}` }
            });
            if (fileCheck.ok) {
                const fileData = await fileCheck.json();
                sha = fileData.sha;
            }

            const putRes = await fetch(`https://api.github.com/repos/${username}/${repo}/contents/${file.path}`, {
                method: 'PUT',
                headers: { 
                    'Authorization': `token ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    message: file.message,
                    content: file.content,
                    sha: sha
                })
            });

            if (!putRes.ok) throw new Error(`Failed to upload ${file.path}`);
        }

        ghLog(`All files synced!`, 'success');
        ghLog(`Visit your repository: https://github.com/${username}/${repo}`, 'success');
        ghLog(`Note: Go to Settings > Pages and ensure 'Source' is set to 'GitHub Actions'.`, 'info');
        
        btn.innerHTML = `<span class="material-symbols-outlined">check</span> Done`;
        setTimeout(() => {
            window.open(`https://github.com/${username}/${repo}/actions`, '_blank');
            closeGithubModal();
            btn.disabled = false;
            btn.innerHTML = `Sync Project`;
        }, 3000);

    } catch (error) {
        console.error(error);
        ghLog(error.message, 'error');
        btn.disabled = false;
        btn.innerHTML = `Retry Sync`;
    }
}
