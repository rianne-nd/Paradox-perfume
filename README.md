# Paradox Manila

A dynamic e-commerce website for Paradox Manila, featuring a PHP/MySQL backend and a "Messenger-First" checkout experience.

## 🚀 Quick Start Guide

### Prerequisites
1.  **XAMPP** (or any PHP/MySQL environment) installed.
    - Download: [https://www.apachefriends.org/](https://www.apachefriends.org/)

### Step 1: Start the Server
1.  Open **XAMPP Control Panel**.
2.  Click **Start** next to **Apache**.
3.  Click **Start** next to **MySQL**.

### Step 2: Configure Database Connection
1.  Open `api/db.php`.
2.  Check the `$port` setting (Line 7).
    - Default XAMPP port is usually `3306`.
    - If your MySQL runs on `3307` (or another port), update this value accordingly.

### Step 3: Create the Database
1.  Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
2.  Create a new database named `paradox_db`.
3.  Select the database and click **Import**.
4.  Choose the `database.sql` file from the project root and click **Import**.

### Step 4: Initialize Data
1.  Move the project folder to your server directory (e.g., `C:\xampp\htdocs\Paradox-perfume`).
2.  Run the setup scripts in your browser:
    - **Populate Products**: [http://localhost/Paradox-perfume/setup_products.php](http://localhost/Paradox-perfume/setup_products.php)
    - **Create Admin**: [http://localhost/Paradox-perfume/setup_admin.php](http://localhost/Paradox-perfume/setup_admin.php)
      - Default Admin: `admin` / `admin123`

### Step 5: Access the Site
- **Storefront**: [http://localhost/Paradox-perfume/index.php](http://localhost/Paradox-perfume/index.php)
- **Admin Panel**: [http://localhost/Paradox-perfume/admin/login.php](http://localhost/Paradox-perfume/admin/login.php)

---

## 📂 Project Structure

```
Paradox-perfume/
├── admin/                  # Admin Dashboard (Login, Orders, Inventory)
├── api/                    # Backend Logic (DB Connection, API Endpoints)
├── assets/                 # Static Assets (Images, JS, CSS)
├── database.sql            # Database Schema
├── index.php               # Main Storefront
├── checkout.html           # Checkout Page
├── collections.html        # Collections Page
├── faq.html                # FAQ Page
└── README.md               # This file
```

## 🛠️ Technical Overview

### Frontend
- **HTML5/CSS3**: Custom styling with a luxury aesthetic.
- **Bootstrap 5**: Responsive grid and components (Modals, Off-canvas).
- **JavaScript**: Client-side cart logic using `localStorage`.

### Backend
- **PHP**: Server-side rendering and API logic.
- **MySQL**: Relational database for Products, Users, and Orders.
- **PDO**: Secure database connections with prepared statements.

### Key Features
- **Dynamic Inventory**: Products are fetched from the database.
- **Stock Management**: Real-time stock checking and deduction.
- **Messenger Integration**: "Copy & Redirect" checkout flow for personalized service.
- **Admin Dashboard**: Secure area to view orders and manage stock.

## ⚠️ Important Notes
- **Security**: The default admin password (`admin123`) is for development only. Change it immediately in a production environment.
- **Cleanup**: After setting up the project, you should delete `setup_products.php` and `setup_admin.php` to prevent data resets.
