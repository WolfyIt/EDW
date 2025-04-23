# Halcon - Construction Material Distributor

This Laravel application automates internal processes for Halcon, allowing customers and staff to track and manage orders with photographic evidence and role-based access.

## Features

- Public Order Lookup:
  - Search by customer number & invoice number from a public form.
  - Display order status and details.
  - Show "In Process" timestamp, "In Route" loading photo, and "Delivered" delivery photo.

- Admin Dashboard (protected by `auth`):
  - Default seeders for department roles: Sales, Purchasing, Warehouse, Route.
  - Default administrator user: `admin@halcon.test` / `secret123`.
  - CRUD for users, products, customers, and orders.
  - Role-based restrictions: upload evidence photos only visible to Route department.
  - Logical delete (archive) of orders with separate view and restore action.
  - Filtering of orders by invoice, customer, date, and status.
  - Flash notifications for success and error messages.

- Database Migrations & Seeders:
  - Orders table with `archived`, `photo_route`, `photo_delivered` fields.
  - Seeders for roles and admin user.

## Installation

1. Clone repository and navigate to project root.
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node dependencies & compile assets:
   ```bash
   npm install
   npm run dev
   ```
4. Configure environment variables:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
5. Run database migrations & seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```
6. Serve the application:
   ```bash
   php artisan serve
   ```

Open http://localhost:8000 in your browser.

## Default Credentials

- Email: `admin@halcon.test`
- Password: `secret123`

## Tests & Validation

After development, verify:
- Public search reflects correct status and photos.
- Login redirects to Admin Dashboard.
- Order CRUD, archiving, and restoration work.
- Role restrictions prevent unauthorized photo uploads.

---

*Generated on April 22, 2025.*
