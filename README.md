# AriaTechShop-ERP

## Project Description

AriaTechShop-ERP is an Enterprise Resource Planning (ERP) application designed to manage various business processes for Aria Tech Shop. This project serves as a comprehensive example of integrating a modern frontend with a robust backend, providing tools for inventory management, sales tracking, and customer relations.

## Tech Stack

The application is built using a modern full-stack approach:

### Backend

- **Framework:** Laravel v12 (PHP)
- **Database:** (Please specify your preferred database, e.g., MySQL, PostgreSQL, SQLite)
- **Package Management:** Composer
- **Asset Bundling:** Vite

### Frontend

- **Framework:** React v19 (TypeScript)
- **Routing:** React Router DOM
- **Styling:** Tailwind CSS
- **Build Tool:** Vite
- **Package Management:** pnpm

## Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP:** Version 8.2 or higher
- **Composer:** Latest stable version
- **Node.js:** Version 18 or higher (LTS recommended)
- **pnpm:** (Recommended package manager for client-side dependencies) `npm install -g pnpm`
- **A database server:** (e.g., MySQL, PostgreSQL, or SQLite)

## Installation Guide

Follow these steps to set up and run the AriaTechShop-ERP application on your local machine.

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/AriaTechShop-ERP.git
cd AriaTechShop-ERP
```

### 2. Server Setup (Laravel Backend)

Navigate into the `server` directory:

```bash
cd server
```

a. **Install PHP Dependencies**

    ```bash
    composer install
    ```

b. **Environment Configuration**

    Copy the example environment file and generate an application key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    Open the newly created `.env` file and configure your database connection and other environment variables.

c. **Database Migration**

    Run the database migrations to set up the necessary tables:

    ```bash
    php artisan migrate
    ```

d. **Install Node.js Dependencies (for Server Assets)**

    ```bash
    pnpm install # or npm install
    ```

e. **Build Server Assets**

    ```bash
    pnpm run build # or npm run build
    ```

### 3. Client Setup (React Frontend)

Navigate back to the root directory and then into the `client` directory:

```bash
cd ..
cd client
```

a. **Install Node.js Dependencies**

    ```bash
    pnpm install
    ```

b. **Build Client Assets (Optional, for production build)**

    ```bash
    pnpm run build
    ```

## Running the Application

### 1. Start the Server (Laravel)

Navigate to the `server` directory and start the Laravel development server. You can use the `composer dev` script to run both the Laravel server and Vite for hot-reloading server-side assets concurrently.

```bash
cd server
composer dev
```

Alternatively, to run them separately:

```bash
# In one terminal
php artisan serve

# In another terminal for asset hot-reloading
pnpm run dev # or npm run dev
```

### 2. Start the Client (React)

Navigate to the `client` directory and start the React development server:

```bash
cd client
pnpm run dev
```

The client application should now be accessible in your web browser, typically at `http://localhost:5173` (or similar, as indicated by Vite).

## Testing

### Server Tests

To run the Laravel backend tests:

```bash
cd server
php artisan test
```
