# homteq - Smart Home E-Commerce Web Application

homteq is a fully functional, dynamic full-stack e-commerce application specializing in smart home devices. The platform features an integrated product catalog, dynamic shopping basket tracking, user authentication states, and an administrative order fulfillment dashboard.

## 🚀 Key Features
* **Dynamic Catalog:** Product inventory loaded securely from a MySQL database with inline quantity selectors.
* **Persistent Smart Basket:** Session-driven shopping cart handles real-time additions, product removals, and automatic subtotal recalculations.
* **Secure Authentication Flow:** Customer and Admin login tiers protected using PHP's `password_verify()` architecture.
* **Transactional Checkout:** Atomic database updates that verify product inventory levels and securely write to `orders` and `order_line` tables using SQL transactions.
* **Admin Fulfillment Portal:** An administrative dashboard allowing staff to track customer order timelines and update pending shipments.

## 🛠️ Technologies Used
* **Backend:** PHP 8.x (Session management, prepared SQL statements)
* **Database:** MySQL / MariaDB (Relational schemas, foreign key constraints)
* **Frontend:** HTML5, CSS3 (Custom fonts, tabular data representations)

## 📦 How to Run Local Environment
1. Clone this repository into your local server directory (e.g., `xampp/htdocs/` or `MAMP/htdocs/`).
2. Import the database schema into your local phpMyAdmin or MySQL client using the provided schema definitions.
3. Configure your database connections inside `db.php`.
4. Open your browser and navigate to `http://localhost/homteq/index.php`.

## 🧠 Engineering Challenges Overcome
* **Session Persistence across Templates:** Resolved a crucial structural issue where different text-casing configurations (`userid` vs `userId`) caused navigation headers to fall out of sync with active customer login states.
* **Database Case-Sensitivity:** Configured and patched SQL relational joins (`orders` to `users`) to use uniform lowercase syntax, preventing structural crashes when migrating between Windows and Unix environment systems.
* **Character Set Layout Glitches:** Remedied data stream encoding issues causing currency characters (`£`) to output as placeholder diamonds (``) by mapping files cleanly to strict HTML entity symbols (`&pound;`).
