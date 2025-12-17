# Paradox Manila

Generated website project. 

## Deployment
This project is configured to deploy to GitHub Pages automatically via Actions. check the 'Actions' tab.

## 
# Backend Setup Guide for Paradox Perfume

This guide explains how to set up and run the **Backend Version** of the Paradox Perfume website (the one with PHP and MySQL).

## Prerequisites
1.  **XAMPP** (or any PHP/MySQL environment) installed.
    - Download: [https://www.apachefriends.org/](https://www.apachefriends.org/)
2.  **Visual Studio Code** (optional, for editing).

---

## Step 1: Start the Server
1.  Open **XAMPP Control Panel**.
2.  Click **Start** next to **Apache**.
3.  Click **Start** next to **MySQL**.

---

## Step 2: Configure the Database Connection
The code is currently configured for a specific port (`3307`). Most XAMPP installations use port `3306`.

1.  Open the file `api/db.php`.
2.  Check line 7: `$port = '3307';`
3.  **If your MySQL port in XAMPP is 3306** (the default):
    - Change it to: `$port = '3306';`
    - Or simply remove the port configuration if you aren't sure (it usually defaults correctly).

---

## Step 3: Create the Database
1.  Open your browser and go to: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2.  Click **New** in the sidebar.
3.  Enter Database Name: `paradox_db`
4.  Click **Create**.

---

## Step 4: Import the Fixed Schema
**IMPORTANT:** Do not use the original `database.sql` file, as it has a bug (it creates an `admins` table, but the code looks for a `users` table).

1.  Select the `paradox_db` database you just created.
2.  Click the **Import** tab at the top.
3.  Click **Choose File**.
4.  Select the file: `FIXED_database.sql` (I created this for you in the project folder).
5.  Click **Import** at the bottom.

---

## Step 5: Populate Data & Create Admin
Now we need to add the products and create your admin account.

1.  Move the entire `Paradox-perfume` folder into your XAMPP `htdocs` folder.
    - Usually: `C:\xampp\htdocs\Paradox-perfume`
2.  Open your browser and run the setup scripts:
    - **Setup Products**: [http://localhost/Paradox-perfume/setup_products.php](http://localhost/Paradox-perfume/setup_products.php)
      - You should see a list of "Inserted: ..." messages.
    - **Setup Admin**: [http://localhost/Paradox-perfume/setup_admin.php](http://localhost/Paradox-perfume/setup_admin.php)
      - This creates a user: `admin` with password: `admin123`.

---

## Step 6: Run the Website
You are now ready to go!

- **Customer View**: [http://localhost/Paradox-perfume/index.php](http://localhost/Paradox-perfume/index.php)
- **Admin Login**: [http://localhost/Paradox-perfume/admin/login.php](http://localhost/Paradox-perfume/admin/login.php)
  - Username: `admin`
  - Password: `admin123`

## Troubleshooting
- **"Connection Refused"**: Check your Port in `api/db.php`.
- **"Table 'users' doesn't exist"**: You likely imported the old `database.sql`. Drop the tables and import `FIXED_database.sql` instead.
