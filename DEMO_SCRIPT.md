# Paradox Manila - Website Demo Script

## 1. Introduction
**Speaker:** "Good [morning/afternoon], everyone. Today, we are excited to present **Paradox Manila**, a dynamic e-commerce platform designed for a seamless perfume shopping experience. Our goal was to create a user-friendly storefront that integrates a 'Messenger-First' checkout approach while providing a robust backend for inventory and order management."

**Key Features:**
*   **Customer-Centric Design:** Clean, aesthetic interface for browsing perfume collections.
*   **Messenger-First Checkout:** Streamlined ordering process that connects directly to social media.
*   **Admin Dashboard:** Comprehensive tools for managing orders, inventory, and sales.
*   **Tech Stack:** Built using **PHP**, **MySQL**, **HTML/CSS**, and **JavaScript**.

---

## 2. Customer Journey (The Storefront)

### Step 1: Landing Page
**Action:** Open `index.php` (Home Page).
**Speaker:** "We start at the **Home Page**. As you can see, we have a visually appealing layout that immediately showcases our brand identity. The navigation bar on top allows easy access to different sections like Collections and FAQs."

### Step 2: Browsing Collections
**Action:** Navigate to `collections.html` or scroll to the "Featured Collections" section.
**Speaker:** "Clicking on **Collections** takes us to our product catalog. Here, customers can browse through our various scent profiles—Citrus, Floral, Woody, etc. Each product card displays the perfume name, price, and an 'Add to Cart' button."

### Step 3: Adding to Cart
**Action:** Click "Add to Cart" on a few items. Open the Cart modal/sidebar.
**Speaker:** "When a customer finds a scent they love, they can simply add it to their cart. The cart updates instantly, allowing them to review their selected items and the total price."

### Step 4: Checkout Process
**Action:** Click "Checkout" to proceed to `checkout.html`.
**Speaker:** "Proceeding to checkout, we have a streamlined form. A unique feature here is the **Social Link** field. Since Paradox Manila operates with a personal touch, we require customers to provide their Facebook or Instagram handle. This facilitates our 'Messenger-First' approach, ensuring we can easily contact them for order confirmation and updates."
**Action:** Fill out the form and click "Place Order".
**Speaker:** "Once the order is placed, the system saves the details to our database and prepares a summary."

---

## 3. Admin Journey (The Backend)

### Step 1: Admin Login
**Action:** Navigate to `admin/login.php`.
**Speaker:** "Now, let's switch hats and look at the **Admin Panel**. Security is paramount, so we have a dedicated login page protected by PHP sessions. I'll log in using the administrator credentials."
*(Enter credentials: `admin` / `admin123`)*

### Step 2: Dashboard Overview
**Action:** Land on `admin/index.php`.
**Speaker:** "Welcome to the **Admin Dashboard**. This is the command center for the business owner. At a glance, we can see key metrics like Total Orders, Pending Orders, and Revenue."

### Step 3: Order Management
**Action:** Scroll to the "Recent Orders" or "Order Ledger" section.
**Speaker:** "Here in the **Order Ledger**, we can see the order we just placed. It captures all necessary details, including the customer's contact info and social handle. The admin can view the order details and update the status—from 'Pending' to 'Paid' or 'Shipped'—keeping the workflow organized."

### Step 4: Inventory Management
**Action:** Show the "Inventory" section.
**Speaker:** "Managing stock is crucial. Our system tracks inventory levels in real-time. It automatically flags items that are 'Low Stock' or 'Out of Stock', preventing overselling and helping the admin know when to restock."

---

## 4. Technical Highlights

**Speaker:** "Under the hood, Paradox Manila is built on a solid foundation:"
*   **Backend:** We use **PHP** for server-side logic, handling form submissions, session management, and database interactions.
*   **Database:** A **MySQL** database stores all product, order, and admin user data.
*   **API Structure:** We've organized our backend into an `api/` folder (e.g., `api/products.php`, `api/orders.php`) to keep our code modular and maintainable.
*   **Security:** We implement transaction-based stock deduction to ensure data integrity during high-traffic periods.

---

## 5. Conclusion
**Speaker:** "In summary, Paradox Manila is more than just a website; it's a complete e-commerce solution tailored for a boutique perfume brand. It bridges the gap between a professional online store and personal social media engagement. Thank you for your time, and we're happy to answer any questions!"
