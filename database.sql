-- Create the database
CREATE DATABASE IF NOT EXISTS paradox_db;
USE paradox_db;

-- Table for Admin Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Products (Optional, if you want to manage stock dynamically later)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 100,
    category VARCHAR(50),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    ig_handle VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    items_json JSON,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Paid', 'Shipped', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a default admin user
-- Username: admin
-- Password: admin123
-- Note: The password hash below corresponds to 'admin123'
INSERT INTO users (username, password) VALUES ('admin', '$2y$10$8Wk.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1'); 
-- IMPORTANT: You should change this password immediately after logging in or generate a new hash.
-- Since I cannot generate a real bcrypt hash here without running PHP, please run the 'setup_admin.php' script I will provide to create a real user.
