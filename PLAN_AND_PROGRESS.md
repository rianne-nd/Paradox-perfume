# Paradox Manila: Backend & Admin Implementation Status

## Project Overview
**Objective:** Transform the static HTML catalog into a dynamic PHP/MySQL web application with a "Messenger-First" commerce model.
**Current Status:** ✅ Implementation Complete (Ready for Local Testing)

---

## 📅 Implementation Plan & Progress

### Phase 1: Database Architecture
- [x] **Refine Schema**: Created `database.sql` with normalized tables:
    - `admins`: Secure login storage.
    - `products`: Dynamic inventory.
    - `orders`: Customer and transaction data.
    - `order_items`: Linked items for each order (Normalized).
- [x] **Data Migration**: Created `setup_products.php` to migrate hardcoded JS data into MySQL.

### Phase 2: Core Backend Infrastructure (`api/`)
- [x] **Database Connection (`db.php`)**: Implemented secure PDO connection.
- [x] **Product API (`products.php`)**:
    - `GET`: Fetches active products for the frontend.
    - `POST`: Updates stock levels (Admin).
- [x] **Order API (`orders.php`)**:
    - `POST`: Receives order data, saves to DB, and returns Order ID.
    - `GET`: Fetches orders for the Admin Dashboard.

### Phase 3: Admin Dashboard (`admin/`)
- [x] **Login System (`login.php`)**: Secure session-based authentication.
- [x] **Dashboard UI (`index.php`)**:
    - **At-A-Glance**: Total Revenue and Pending Orders counters.
    - **Order Ledger**: Table view of all orders with status.
    - **Inventory Management**: Editable stock fields for products.

### Phase 4: Frontend Integration
- [x] **Dynamic Store (`index.php`)**: Converted `index.html` to PHP. Products are now rendered server-side from the database.
- [x] **Checkout Logic (`assets/script.js` & `checkout.html`)**:
    - Updated `copyAndRedirect()` function.
    - **Flow**: User clicks "Complete Purchase" -> Data sent to `api/orders.php` -> Order ID returned -> Text copied to clipboard -> Redirect to Messenger.

### Phase 5: File Structure Organization
- [x] **Restructuring**:
    - Created `assets/` for CSS, JS, and Images.
    - Created `api/` for backend logic.
    - Created `admin/` for the dashboard.
    - Cleaned up the root directory.
- [x] **Cleanup & Optimization**:
    - Removed temporary database fix scripts (`fix_*.php`).
    - Consolidated database schema into `database.sql`.
    - Removed legacy backup files.

---

## 📂 Current File Structure
```
Paradox-perfume/
├── admin/                  # Admin Dashboard
│   ├── index.php           # Dashboard, Orders, Inventory
│   ├── login.php           # Login Page
│   └── logout.php
├── api/                    # Backend Logic
│   ├── db.php              # Database Connection
│   ├── orders.php          # Order Processing
│   └── products.php        # Product Data
├── assets/                 # Static Assets
│   ├── Images/             # Product Images
│   ├── script.js           # Frontend Logic (Cart, Checkout)
│   └── style.css           # Styles
├── database.sql            # SQL Schema (Updated with 'users' table)
├── index.php               # Main Storefront (Dynamic)
├── checkout.html           # Checkout Page
├── collections.html        # Static Collections Page (Client-side rendering)
├── faq.html                # FAQ Page
├── setup_products.php      # One-time migration script (WebP ready)
└── README.md
```

---

## 🚀 How to Run (Local Setup)

1.  **Start XAMPP**:
    *   Start **Apache** and **MySQL**.

2.  **Setup Database**:
    *   Go to `http://localhost/phpmyadmin`.
    *   Create a new database named `paradox_db`.
    *   Import `database.sql` from the project folder.

3.  **Populate Products**:
    *   Run the migration script once:
    *   `http://localhost/Paradox/Paradox-perfume/setup_products.php`

4.  **Test the Store**:
    *   Visit: `http://localhost/Paradox/Paradox-perfume/index.php`

5.  **Access Admin Panel**:
    *   URL: `http://localhost/Paradox/Paradox-perfume/admin/login.php`
    *   **User**: `admin`
    *   **Pass**: `admin123` (⚠️ Change this immediately!)
