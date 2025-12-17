# Paradox Manila - Technical Documentation

## Overview
This document outlines the technical architecture, design decisions, and system workflows for the Paradox Manila e-commerce platform. The system is designed to bridge the gap between a modern digital storefront and a personalized, messenger-based sales process.

---

## 1. The Frontend (User Interface)
The frontend is built to deliver a luxury aesthetic while ensuring performance and responsiveness across all devices.

*   **HTML5 & CSS3**: 
    *   Used for the core semantic structure and custom branding.
    *   Features unique section backgrounds for each collection (e.g., *"The Floral Reverie"*, *"Sunlit Essence"*) to create an immersive visual experience.
    *   **Key Files**: `index.php`, `assets/style.css`

*   **Bootstrap 5**: 
    *   Implemented for the responsive grid system, ensuring the layout adapts seamlessly from desktop to mobile.
    *   Utilizes Bootstrap components such as the **Off-canvas Shopping Bag** and **Interactive Modals** (e.g., Scent Finder).

*   **Vanilla JavaScript**: 
    *   Custom logic handles the client-side cart system using `localStorage`.
    *   Allows users to add items, update quantities, and view totals instantly without requiring page reloads.
    *   **Key File**: `assets/script.js`

*   **Typography & Icons**: 
    *   **Fonts**: Integrated Google Fonts (*Playfair Display* for headings, *Lato* for body text) to convey a premium brand identity.
    *   **Icons**: Utilizes *Material Symbols* for a clean, modern, and consistent UI icon set.

---

## 2. The Backend (Server-Side Logic)
The backend transforms the static design into a dynamic, data-driven application.

*   **PHP**: 
    *   Serves as the core server-side language.
    *   Converted static HTML pages into dynamic PHP scripts (e.g., `index.php`).
    *   Automatically renders product cards by fetching real-time data from the database.

*   **MySQL Database**: 
    *   A relational database designed with four primary tables:
        1.  `products`: Manages inventory, pricing, and image paths.
        2.  `users`: Handles secure admin access and authentication.
        3.  `orders`: Stores customer transaction details.
        4.  `order_items`: Links specific products to orders for detailed tracking.
    *   **Schema File**: `FIXED_database.sql`

*   **Secure Connection (PDO)**: 
    *   Database interactions are handled via **PHP Data Objects (PDO)**.
    *   Utilizes **Prepared Statements** exclusively to prevent SQL injection attacks and ensure data security.
    *   **Key File**: `api/db.php`

---

## 3. System Logic & Workflow
The system logic is designed to handle inventory integrity and facilitate the unique "Messenger-First" sales model.

*   **Inventory & Order Processing**: 
    *   **File**: `place_order.php`
    *   Implements database transactions to ensure atomicity.
    *   Checks stock levels *before* confirming an order.
    *   Automatically deducts items from the `products` table upon successful order placement to prevent overselling.

*   **Messenger-First Integration**: 
    *   Recognizing the brand's focus on personal service, the checkout flow is hybrid.
    *   **"Copy & Redirect" Feature**: When a user clicks "Complete Purchase":
        1.  The order is saved to the database for record-keeping.
        2.  A formatted summary is copied to the user's clipboard.
        3.  The user is redirected to Facebook Messenger to paste the details and finalize payment/shipping personally.

---

## 4. Administrative Tools
A suite of tools built to manage the business operations efficiently.

*   **Admin Dashboard**: 
    *   **Location**: `admin/` directory.
    *   A protected area requiring secure login.
    *   **Features**:
        *   View total revenue and sales metrics.
        *   Manage the order ledger (view pending/completed orders).
        *   Update product stock levels in real-time.

*   **One-Time Setup Scripts**: 
    *   **File**: `setup_products.php`
    *   Automates the initial migration of the product catalog into the MySQL database, simplifying the deployment process.
