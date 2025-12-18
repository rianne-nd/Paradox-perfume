# Cleanup and Optimization Plan

## Objective
To sanitize the project workspace by removing temporary fix scripts, consolidating database schemas, and ensuring all configuration files reflect the current stable state of the application (WebP images, correct table names).

## Action Items

### 1. Database Schema Consolidation
- **Current State**: Two schema files exist: `database.sql` (uses `admins` table) and `FIXED_database.sql` (uses `users` table). The application logic (`api/login.php`) uses the `users` table.
- **Action**: 
    - Update `database.sql` to use the `users` table definition.
    - Delete `FIXED_database.sql`.

### 2. Removal of Temporary Fix Scripts
- **Files to Remove**:
    - `fix_cool_water_image.php`: One-time script to fix a specific double-extension bug.
    - `fix_db_images.php`: Batch script used to migrate DB paths from .png to .webp.
    - `update_images_to_webp.php`: Redundant/Older version of the image update script.
- **Reasoning**: The database has been successfully patched. `setup_products.php` already contains the correct `.webp` paths for any fresh installations.

### 3. Removal of Backup Files
- **Files to Remove**:
    - `index_tailwind_backup.html`: Old backup file no longer needed as the main `index.php` is fully functional and version controlled.

### 4. Documentation Update
- **Action**: Update `PLAN_AND_PROGRESS.md` to mark the cleanup phase as complete and reflect the streamlined file structure.

## Verification
- Ensure `setup_products.php` contains correct `.webp` paths (Verified).
- Ensure `api/login.php` matches the table name in the updated `database.sql` (Verified: `users` table).
