# BirthDay App

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A professional multi-tenant Laravel PWA application featuring a Stranger Things-themed countdown landing page and a comprehensive mobile-first admin dashboard for capturing and managing life's most precious moments.

## 🌟 Project Overview

**BirthDay App** is designed to be a personal digital scrapbook. It combines a visually stunning landing page with a powerful backend for managing "Moments"—memories consisting of titles, descriptions, dates, and locations. Built with a mobile-first philosophy, the application is fully Progressive Web App (PWA) compliant, allowing users to install it on their devices for an app-like experience.

### Key Architectural Highlight: Multi-Tenancy
The application supports **Multi-Tenancy** using a single shared database architecture. This allows multiple independent organizations or individuals to use the same platform with complete data isolation, served via dedicated subdomains or custom domains.

---

## ✨ Features

- **Stranger Things Landing Page**: Immersive countdown timer with video backgrounds and thematic styling.
- **Multi-Tenant Architecture**: Dynamic tenant creation with isolated data, settings, and users.
- **Mobile-First Admin Dashboard**:
  - **Timeline View**: Chronological display of moments grouped by date.
  - **Interactive Calendar**: Monthly view with event indicators.
  - **Geospatial Map**: Leaflet-powered map visualizing moments by location.
  - **Dynamic Navigation**: Fully customizable navigation menu managed via the admin panel.
- **PWA Ready**: Offline support, manifest configuration, and install prompts for iOS and Android.
- **SuperAdmin Portal**: Centralized management for tenants, global settings, and user provisioning.

---

## 🛠 Technology Stack

- **Framework**: [Laravel 12.x](https://laravel.com)
- **Tenancy**: [Stancl Tenancy](https://tenancyforlaravel.com/)
- **Frontend**: Tailwind CSS, Blade Templates
- **Maps**: [Leaflet.js](https://leafletjs.com/)
- **Database**: SQLite (Development) / MySQL (Production)
- **PWA**: Workbox / Service Workers

---

## 🚀 Installation Guide

### Prerequisites
- PHP 8.2 or higher
- Composer
- SQLite (for local development) or MySQL
- Node.js & NPM (for frontend assets)

### Step-by-Step Setup

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd moments
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   Copy the example environment file and generate the application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Initialization**
   Ensure your database is configured in `.env`. Then run the migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
   *Note: This will create the central database schema and initial tenants.*

5. **Storage Link**
   Create a symbolic link for storage:
   ```bash
   php artisan storage:link
   ```

6. **Compile Assets**
   ```bash
   npm run build
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```

---

## 📖 Usage & Documentation

### Accessing the Application
- **Central Landing Page**: `http://localhost:8000`
- **SuperAdmin Panel**: `http://localhost:8000/admin/login`
- **Tenant Admin Dashboard**: `http://<tenant-id>.localhost:8000/admin/timeline`

### Managing Tenants
Tenants are identified by their subdomain. For local development, use subdomains like `tenant1.localhost`. 
Detailed multi-tenancy documentation can be found in [TENANCY.md](file:///c:/xampp/htdocs/moments/TENANCY.md).

### Default Credentials
- **SuperAdmin**: Managed via `super_admins` table (Seed defaults provided).
- **Tenant User**: `user1@tenant1.com` / `password` (if seeded).

---

## 📂 Project Structure

A high-level overview of the codebase:

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Tenant-specific admin logic
│   │   ├── SuperAdmin/      # Central management logic
│   │   └── Auth/            # Authentication handlers
│   ├── Models/              # Tenant-aware Eloquent models
│   └── Providers/           # Tenancy and App service providers
├── config/                  # Configuration files (tenancy.php, etc.)
├── database/
│   ├── migrations/          # Shared database schema
│   └── seeders/             # Initial data and tenant provisioning
├── resources/views/
│   ├── admin/               # Tenant dashboard views
│   ├── superadmin/          # Central dashboard views
│   └── errors/              # Custom error pages (e.g., 404-tenant)
└── routes/
    ├── web.php              # Central/SuperAdmin routes
    └── tenant.php           # Tenant-specific routes
```

---

## 🔧 Troubleshooting

| Issue | Solution |
| :--- | :--- |
| **Tenant Not Found (404)** | Ensure the subdomain matches a record in the `domains` table. |
| **Database Connection Error** | Verify `DB_CONNECTION` and credentials in your `.env` file. |
| **PWA Not Installing** | Ensure you are accessing the site over HTTPS or `localhost`. |
| **Images Not Showing** | Run `php artisan storage:link` and check file permissions. |

---

## 🤝 Contribution Guidelines

We welcome contributions! Please follow these steps:
1. Fork the project.
2. Create a feature branch (`git checkout -b feature/AmazingFeature`).
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4. Push to the branch (`git push origin feature/AmazingFeature`).
5. Open a Pull Request.

---

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.

---
*Created by the Moments Team*
