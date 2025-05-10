# EDW Halcón - Construction Material Distributor

This Laravel application automates internal processes for Halcón, allowing customers and staff to track and manage orders with photographic evidence and role-based access.

## Features

- **Public Order Lookup**:
  - Search by customer number & invoice number from a public form
  - Display order status and details
  - Show "In Process" timestamp, "In Route" loading photo, and "Delivered" delivery photo

- **Protected Dashboard** (requires authentication):
  - Role-based access control system
  - CRUD for users, products, customers, and orders
  - Dynamic UI with user avatars and role-specific navigation
  - Logical delete (archive) of orders with separate view and restore action
  - Advanced filtering of orders by invoice, customer, date, and status
  - Real-time calculation of order totals
  - Flash notifications for success and error messages

- **Order Photo System**:
  - Each order can have up to 2 photos: processing photo and delivery confirmation photo
  - Processing photo can be added only for orders with 'pending' or 'processing' status
  - Delivery photo can be added only for orders with 'completed' status
  - Dynamic photo upload fields based on order status
  - Photo indicators in order list to show which photos are available
  - Side-by-side display of photos in order detail view

- **Role-Based System**:
  - **Admin**: Full access to all system features and modules (Users, Products, Customers, Orders)
  - **Warehouse**: Access to Orders and Products modules with inventory management
  - **Sales**: Access to Orders module with customer and order management
  - **Purchasing**: Access to Orders and Products modules with supply chain features
  - **Route**: Access to Orders module with ability to upload evidence photos

- **UI Enhancements**:
  - User avatar circles with initials in navigation menu
  - Role-specific color coding for visual identification
  - Improved navigation with translucent backgrounds
  - Responsive design for mobile and desktop use

## Technology Stack
- **Backend**: Laravel 11
- **Frontend**: Blade templates with Vue.js components
- **Database**: MySQL
- **Authentication**: Laravel's built-in authentication
- **Styling**: Custom CSS with responsive design

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

Each role has a default user account for testing:

- **Admin**:
  - Email: `admin@halcon.test`
  - Password: `secret123`
  
- **Warehouse**:
  - Email: `warehouse@halcon.test`
  - Password: `password123`
  
- **Sales**:
  - Email: `sales@halcon.test`
  - Password: `password123`
  
- **Purchasing**:
  - Email: `purchasing@halcon.test`
  - Password: `password123`
  
- **Route**:
  - Email: `route@halcon.test`
  - Password: `password123`

## Tests & Validation

After deployment, verify:
- Public search reflects correct status and photos
- Login redirects to role-appropriate dashboard
- Order CRUD, archiving, and restoration work properly according to role permissions
- Role restrictions prevent unauthorized actions
- Order calculations show correct totals
- Image uploads work correctly for Route users
- Navigation elements display properly based on user role

---

*Updated on May 8, 2025*