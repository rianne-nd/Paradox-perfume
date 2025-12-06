# Project Progress & Status

## Current Status: Static Frontend (Legacy/Reference Version)
**Date:** December 7, 2025

This version of the project (`Paradox-perfume - Copy`) has been converted to a purely static website to serve as a stable reference and backup. All non-functional backend code has been removed to streamline the codebase.

### Recent Updates
- **Backend Removal**: 
  - Removed all PHP files (`db.php`, `place_order.php`, `setup_admin.php`).
  - Removed `api/` directory and endpoints.
  - Removed `database.sql`.
  - Removed `admin.html` (Admin dashboard requires backend).
- **Cleanup**:
  - Deleted unused backup files (`index_tailwind_backup.html`).
- **Documentation**:
  - Added extensive comments to `index.html`, `script.js`, `style.css`, and `checkout.html` to explain the core logic.

### Active Features
1.  **Product Catalog**: `collections.html` displays products with filtering (Floral, Citrus, etc.).
2.  **Shopping Cart**: Client-side cart using `localStorage` (handled in `script.js`).
3.  **Checkout**: `checkout.html` collects user details and generates a pre-formatted message for Facebook Messenger.
4.  **Scent Finder**: Interactive quiz in `index.html`.

### Next Steps
- Maintain this folder as a static reference.
- Continue development of the dynamic backend in the main `Paradox-perfume` repository.
