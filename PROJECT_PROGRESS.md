# Project Progress Tracker

## Overview
This document tracks the development progress, features implemented, and structural changes made to the Paradox Perfume project. It serves as a comparison between the original static/flat structure and the current backend-integrated version.

## Migration Analysis (Original vs. Current)

### 1. Structural Refactoring
| Feature | Original (`Paradox-perfume - Copy`) | Current (`Paradox-perfume`) |
| :--- | :--- | :--- |
| **Root Directory** | Cluttered with assets (`Images/`, `style.css`, `script.js`) and mixed HTML/PHP files. | Cleaned up. Assets moved to `assets/` directory. Admin files moved to `admin/`. |
| **Assets** | `Images/`, `style.css`, `script.js` in root. | `assets/Images/`, `assets/style.css`, `assets/script.js`. |
| **Admin Portal** | Single `admin.html` file (Client-side rendering). | Dedicated `admin/` directory with `index.php` (Server-side rendering & Session Auth). |
| **Database Config** | `db.php` in root. | Moved to `api/db.php` for better separation of concerns. |
| **Main Page** | `index.html` | Renamed to `index.php` to support future dynamic content. |

### 2. Functional Enhancements

#### Admin Dashboard
*   **Before**: `admin.html` likely relied on JavaScript to fetch data and toggle views (Login/Dashboard) within a single file. No server-side session protection was visible in the file structure.
*   **After**: 
    *   **Security**: Implemented `admin/login.php` and `admin/logout.php` with PHP Sessions (`$_SESSION['admin_logged_in']`).
    *   **Dashboard (`admin/index.php`)**: Now renders data directly from the database using PHP.
    *   **Inventory**: Added "Low Stock" and "Out of Stock" logic. Removed the "Add Product" button and "Delete" action to streamline the view as per recent requests.
    *   **Order Ledger**: Added "Contact Number" to the Order Details modal.

#### Checkout & Order Processing
*   **Checkout Page**:
    *   **Before**: Standard inputs.
    *   **After**: Added **Facebook/Instagram Link** field (Required). Updated `checkout.html` logic to include this in the auto-generated Messenger text.
*   **Order Backend (`place_order.php`)**:
    *   **Before**: Simple `INSERT` into `orders` table. Included placeholder code for Telegram notifications. No stock management.
    *   **After**: 
        *   **Stock Management**: Implemented **Transaction-based Stock Deduction**. Checks if `stock_qty` is sufficient before placing order. Rolls back if insufficient.
        *   **Data Handling**: Captures and saves `ig_handle` (Social Link) to the database.
        *   **Cleanup**: Removed unused Telegram bot code.

#### API Development
*   **New Endpoints**:
    *   `api/products.php`: Handles product updates (Price/Stock).
    *   `api/orders.php`: (Created) For fetching order data asynchronously if needed.
    *   `api/update_status.php`: For updating order status (Pending -> Paid -> Shipped, etc.).

## Recent Updates (December 7, 2025)

### 1. Project Restructuring
- **Assets Organization**: 
  - Moved all images to `assets/Images/`.
  - Moved stylesheets to `assets/style.css`.
  - Moved JavaScript files to `assets/script.js`.
- **Directory Structure**:
  - Created `admin/` directory for administrative pages.
  - Created `api/` directory for backend logic and API endpoints.

### 2. Admin Panel Implementation (`admin/`)
- **Dashboard (`admin/index.php`)**:
  - **Overview Cards**: Displays Total Revenue, Pending Orders, Total Orders, and Low Stock alerts.
  - **Recent Orders**: Quick view of the latest 5 orders.
- **Order Ledger**:
  - Full list of orders with status management (Pending, Paid, Shipped, Completed, Cancelled).
  - **Order Details Modal**: View customer info (Name, IG Handle, Phone, Address) and ordered items.
  - **Status Updates**: Real-time status updates via dropdown.
- **Inventory Management**:
  - List of all products with images, categories, prices, and stock levels.
  - **Quick Edits**: Inline editing for Price and Stock Quantity.
  - **Stock Alerts**: Visual indicators for Low Stock (< 20) and Out of Stock.
  - *Refinement*: Removed "Add Product" button and "Action" column (delete) as per requirements.
- **Authentication**:
  - Created `admin/login.php` for secure access.
  - Created `admin/logout.php` for session termination.

### 3. Checkout Process Enhancements
- **Checkout Page (`checkout.html`)**:
  - Added **Facebook/Instagram Link** input field (Required).
  - Updated "Complete Purchase" logic to validate all fields including the social link.
  - Updated the auto-generated message to include the social link for Messenger.
  - **Cart Features**:
    - Added **Cart Count Badge** to the navbar icon.
    - Implemented **Real-time Stock Display** ("X in stock") in the order summary.
    - Added **Stock Validation** to prevent users from increasing quantity beyond available stock.
- **Backend Processing (`place_order.php`)**:
  - Updated database insertion logic to save the `ig_handle` (Social Link).
  - Implemented stock deduction logic upon order placement.

### 4. Backend API Development (`api/`)
- **`api/db.php`**: Centralized database connection using PDO.
- **`api/login.php`**: Handles admin login verification.
- **`api/update_status.php`**: Endpoint for updating order statuses.
- **`api/products.php`**: Endpoint for updating product details (price/stock).
- **`api/get_data.php`**: Utility for fetching data (if applicable).

### 5. Database
- **Schema**:
  - `products` table: Stores inventory details.
  - `orders` table: Stores order information, customer details, and JSON-encoded items.
  - `admin` table: Stores admin credentials.

### 6. Documentation
- **Legacy Codebase (`Paradox-perfume - Copy`)**:
  - Added extensive inline comments to `index.html`, `script.js`, `style.css`, `checkout.html`, `collections.html`, and `admin.html`.
  - Documented variable roles, function logic, and CSS structure to aid in future migration or reference.

## Recent Updates (December 16, 2025)

### 1. Frontend Restoration & Backend Integration
- **Homepage (`index.php`)**:
  - **Issue**: Homepage was showing an empty product list because it was relying on the old static HTML structure.
  - **Fix**: Implemented **Server-Side Rendering (PHP)** to fetch active products from the database and render the "Featured Collections" sections dynamically.
  - **Cache Busting**: Added versioning to the script tag (`?v=time()`) to prevent browser caching issues.

### 2. Scent Finder Quiz Restoration
- **Issue**: The "Scent Finder" quiz had reverted to a newer "What's your vibe?" design that the client did not prefer.
- **Fix**: 
  - Completely recreated `assets/script.js`.
  - **Restored "Old Look"**: Brought back the "How do you want to feel?" grid layout with Material Symbols icons (Heart, Sun, Water Drop, Diamond).
  - **Hybrid Logic**: Kept the modern `fetch('api/products.php')` backend connection but used the legacy UI logic for the quiz interface.
  - **Result**: The quiz now looks exactly like the original static version but pulls real product data and stock levels from the MySQL database.

## Recent Updates (December 17-18, 2025)

### 1. WebP Image Conversion
- **Optimization**: Converted all project images from `.jpg`/`.png` to `.webp` for better performance and faster load times.
- **Implementation**:
  - Updated all static image references in `index.php`, `checkout.html`, `collections.html`, `faq.html`, and `assets/script.js`.
  - Created `fix_db_images.php` to batch update image paths in the MySQL database.
  - Fixed specific image issues (e.g., "Cool Water" double extension bug).

### 2. Bug Fixes & UI Polish
- **Navigation**:
  - Fixed "About Us" links to correctly point to `index.php#about`.
  - Fixed "Contact Us" button in FAQ to redirect to the Facebook page.
- **Footer**:
  - Added missing Facebook and Instagram logo links to the `checkout.html` footer.
- **Checkout & Cart**:
  - Updated `checkout.html` and `assets/script.js` to prioritize database image paths over local storage cache, ensuring the new `.webp` images display correctly even for items previously added to the cart.

### 3. Version Control
- **Repository**: Initialized Git repository and pushed all changes to the `backend-dev` branch on GitHub.

## Recent Updates (December 20, 2025)

### 1. Production Deployment & Admin Fixes
- **Deployment**:
  - Configured `api/db.php` for InfinityFree hosting environment.
  - Created `production-launch` branch for deployment.
- **Admin Panel Debugging**:
  - **Issue**: Admin login was failing with "Table 'admins' doesn't exist" error on production.
  - **Root Cause**: The production database uses a `users` table for admins, while the code was referencing `admins`. Also, the password column was `password` instead of `password_hash`.
  - **Fix**: Updated `admin/login.php` and `setup_admin.php` to query the `users` table and use the correct column names.
  - **Verification**: Confirmed `admin/login.php` logic matches the production schema.

## Next Steps / To-Do
- [ ] Implement "Add Product" functionality (if re-requested).
- [ ] Add date range filtering for the dashboard.
- [ ] Implement image upload for new products.
- [ ] Enhance security (password hashing, input sanitization).
- [ ] Mobile responsiveness testing for Admin Panel.

## Version Control
- **Current Branch**: `production-launch`
- **Repository**: `Paradox-perfume`
