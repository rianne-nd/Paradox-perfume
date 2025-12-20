<?php
session_start();
require_once __DIR__ . '/../api/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Fetch Stats
$stmt = $pdo->query("SELECT SUM(total_price) as revenue FROM orders WHERE status != 'Cancelled'");
$revenue = $stmt->fetch()['revenue'] ?? 0;

$stmt = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE status = 'pending'");
$pending_orders = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
$total_orders = $stmt->fetch()['count'];

$stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE stock_qty < 20");
$low_stock = $stmt->fetch()['count'];

// Fetch Orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$orders = $stmt->fetchAll();

// Fetch Products (Inventory)
$stmt = $pdo->query("SELECT * FROM products");
$inventory = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Paradox Manila</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,300,0,0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #1a1a1a;
            --accent-color: #d4af37;
            --bg-light: #f8f9fa;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: white;
            border-right: 1px solid #eee;
            padding: 20px;
            z-index: 1000;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            color: #666;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background-color: #f0f0f0;
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: #fff5f5;
            color: #d63384;
        }

        .nav-link .material-symbols-outlined {
            font-size: 20px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }

        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #eee;
            height: 100%;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        /* Tables */
        .custom-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .custom-table th {
            background: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .custom-table td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-paid { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .status-select {
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
        }
        .status-select:focus {
            box-shadow: none;
            border: 1px solid #ced4da;
        }

        .product-img-sm {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="brand">
        <span class="material-symbols-outlined">diamond</span>
        Paradox Admin
    </div>
    
    <nav class="nav flex-column">
        <a href="#" class="nav-link active" onclick="showSection('dashboard', this)">
            <span class="material-symbols-outlined">dashboard</span>
            Dashboard
        </a>
        <a href="#" class="nav-link" onclick="showSection('orders', this)">
            <span class="material-symbols-outlined">receipt_long</span>
            Orders
        </a>
        <a href="#" class="nav-link" onclick="showSection('inventory', this)">
            <span class="material-symbols-outlined">inventory_2</span>
            Inventory
        </a>
    </nav>

    <div class="mt-auto pt-4 border-top">
        <a href="logout.php" class="nav-link text-danger">
            <span class="material-symbols-outlined">logout</span>
            Logout
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    
    <!-- Dashboard Section -->
    <div id="dashboard-section">
        <h2 class="h4 mb-4 fw-bold">Dashboard Overview</h2>
        
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-success-subtle text-success">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <h6 class="text-muted mb-1">Total Revenue</h6>
                    <h3 class="fw-bold mb-0">₱<?php echo number_format($revenue, 2); ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                    <h6 class="text-muted mb-1">Pending Orders</h6>
                    <h3 class="fw-bold mb-0"><?php echo $pending_orders; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h3 class="fw-bold mb-0"><?php echo $total_orders; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon bg-danger-subtle text-danger">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                    <h6 class="text-muted mb-1">Low Stock Items</h6>
                    <h3 class="fw-bold mb-0"><?php echo $low_stock; ?></h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold">Recent Orders</h5>
                    <button class="btn btn-sm btn-outline-dark" onclick="showSection('orders', document.querySelectorAll('.nav-link')[1])">View All</button>
                </div>
                <div class="custom-table">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($orders, 0, 5) as $order): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                <td>₱<?php echo number_format($order['total_price'], 2); ?></td>
                                <td>
                                    <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                                        <?php echo $order['status']; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    <div id="orders-section" style="display:none;">
        <h2 class="h4 mb-4 fw-bold">Order Ledger</h2>
        <div class="custom-table">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): 
                        $items = json_decode($order['items_json'], true);
                        $itemCount = is_array($items) ? count($items) : 0;
                    ?>
                    <tr>
                        <td class="fw-bold">#<?php echo $order['id']; ?></td>
                        <td>
                            <div class="fw-bold"><?php echo htmlspecialchars($order['customer_name']); ?></div>
                            <div class="small text-muted">@<?php echo htmlspecialchars($order['ig_handle']); ?></div>
                        </td>
                        <td><?php echo htmlspecialchars($order['phone']); ?></td>
                        <td><?php echo $itemCount; ?> items</td>
                        <td class="fw-bold">₱<?php echo number_format($order['total_price'], 2); ?></td>
                        <td>
                            <select class="form-select form-select-sm status-select status-<?php echo strtolower($order['status']); ?>" 
                                    onchange="updateStatus(<?php echo $order['id']; ?>, this)">
                                <option value="pending" <?php echo strtolower($order['status']) == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="paid" <?php echo strtolower($order['status']) == 'paid' ? 'selected' : ''; ?>>Paid</option>
                                <option value="shipped" <?php echo strtolower($order['status']) == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="completed" <?php echo strtolower($order['status']) == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo strtolower($order['status']) == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </td>
                        <td class="text-muted small"><?php echo date('M d, Y h:i A', strtotime($order['created_at'])); ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick='viewOrder(<?php echo htmlspecialchars(json_encode($order), ENT_QUOTES, "UTF-8"); ?>)'>
                                <span class="material-symbols-outlined fs-6 align-middle">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Section -->
    <div id="inventory-section" style="display:none;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold mb-0">Inventory Management</h2>
        </div>
        
        <div class="custom-table">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price (₱)</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="../assets/<?php echo htmlspecialchars($item['image_path']); ?>" class="product-img-sm" alt="Product">
                                <div>
                                    <div class="fw-bold"><?php echo htmlspecialchars($item['name']); ?></div>
                                    <div class="small text-muted text-truncate" style="max-width: 200px;"><?php echo htmlspecialchars($item['description']); ?></div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($item['collection']); ?></span></td>
                        <td>
                            <input type="number" class="form-control form-control-sm" style="width: 100px;" 
                                   value="<?php echo $item['price']; ?>" 
                                   onchange="updateProduct(<?php echo $item['id']; ?>, 'price', this.value)">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm <?php echo $item['stock_qty'] < 20 ? 'border-danger text-danger' : ''; ?>" 
                                   style="width: 80px;" 
                                   value="<?php echo $item['stock_qty']; ?>" 
                                   onchange="updateProduct(<?php echo $item['id']; ?>, 'stock', this.value)">
                        </td>
                        <td>
                            <?php if($item['stock_qty'] > 20): ?>
                                <span class="badge bg-success-subtle text-success">In Stock</span>
                            <?php elseif($item['stock_qty'] > 0): ?>
                                <span class="badge bg-warning-subtle text-warning">Low Stock</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger">Out of Stock</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="order-modal-body">
                <!-- Content injected by JS -->
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showSection(id, element) {
    // Hide all sections
    document.getElementById('dashboard-section').style.display = 'none';
    document.getElementById('orders-section').style.display = 'none';
    document.getElementById('inventory-section').style.display = 'none';
    
    // Show selected section
    document.getElementById(id + '-section').style.display = 'block';
    
    // Update active nav link
    if (element) {
        document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
        element.classList.add('active');
    }
}

function updateStatus(id, selectElement) {
    const newStatus = selectElement.value;
    
    // Update color immediately for better UX
    selectElement.className = `form-select form-select-sm status-select status-${newStatus}`;

    fetch('../api/update_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, status: newStatus })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            console.log('Status updated');
        } else {
            alert('Error updating status');
        }
    });
}

function viewOrder(order) {
    const items = JSON.parse(order.items_json || '[]');
    const modalBody = document.getElementById('order-modal-body');
    
    let itemsHtml = items.map(item => `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <div class="fw-bold small">${item.name}</div>
                <div class="text-muted small">x${item.qty}</div>
            </div>
            <div class="fw-bold small">₱${(item.price * item.qty).toFixed(2)}</div>
        </div>
    `).join('');

    modalBody.innerHTML = `
        <div class="mb-4 text-center">
            <h2 class="h1 fw-bold mb-0">₱${parseFloat(order.total_price).toFixed(2)}</h2>
            <span class="badge bg-light text-dark border mt-2">${order.status}</span>
        </div>
        
        <div class="mb-4">
            <h6 class="text-uppercase text-muted small fw-bold mb-3">Customer Info</h6>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="bg-light rounded-circle p-2">
                    <span class="material-symbols-outlined fs-5 align-middle">person</span>
                </div>
                <div>
                    <div class="fw-bold">${order.customer_name}</div>
                    <div class="small text-muted">@${order.ig_handle || 'N/A'}</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="bg-light rounded-circle p-2">
                    <span class="material-symbols-outlined fs-5 align-middle">call</span>
                </div>
                <div class="small">${order.phone}</div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-light rounded-circle p-2">
                    <span class="material-symbols-outlined fs-5 align-middle">location_on</span>
                </div>
                <div class="small">${order.address}</div>
            </div>
        </div>

        <div>
            <h6 class="text-uppercase text-muted small fw-bold mb-3">Order Items</h6>
            <div class="bg-light rounded p-3">
                ${itemsHtml}
            </div>
        </div>
    `;

    new bootstrap.Modal(document.getElementById('orderModal')).show();
}

function updateProduct(id, field, value) {
    const data = { id: id };
    data[field] = value;

    fetch('../api/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            // Optional: Show a toast notification
            console.log('Updated successfully');
        } else {
            alert('Error updating product');
        }
    });
}
</script>

</body>
</html>
