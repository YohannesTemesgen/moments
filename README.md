# Moments

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A professional multi-tenant Laravel PWA application featuring a Stranger Things-themed countdown landing page and a comprehensive mobile-first admin dashboard for capturing and managing life's most precious moments.

## 🌟 Project Overview

**Moments** is designed to be a personal digital scrapbook. It combines a visually stunning landing page with a powerful backend for managing "Moments"—memories consisting of titles, descriptions, dates, and locations. Built with a mobile-first philosophy, the application is fully Progressive Web App (PWA) compliant, allowing users to install it on their devices for an app-like experience.

### Key Architectural Highlight: Multi-Tenancy
The application supports **Multi-Tenancy** using a single shared database architecture (or database-per-tenant depending on configuration). This allows multiple independent organizations or individuals to use the same platform with data isolation.

---

## ✨ Features
### 📸 Moments Management
- **Rich Media Support**: Drag-and-drop multi-image upload system for capturing memories in high detail.
- **Categorization**: Organize moments with custom categories for easy filtering.
- **Geotagging**: Attach precise locations to every moment.

### 📊 Visualization & Organization
- **Timeline View**: A chronological feed of your life's events.
- **Interactive Calendar**: Monthly overview to visualize moments by date.
- **Geospatial Map**: Explore your journey on an interactive **Leaflet.js** map.
- **Dynamic Navigation**: Fully customizable sidebar navigation managed directly from the admin panel.

### 🔐 Security & Administration
- **Multi-Tenant Architecture**: Complete data isolation per tenant (users, settings, and content).
- **SuperAdmin Portal**: centralized dashboard for managing tenants, users, and global system settings.
- **Audit Logging**: Comprehensive activity tracking for security and accountability.
- **Role-Based Access**: Distinct separation between SuperAdmin and Tenant Admin roles.

### 📱 Progressive Web App (PWA)
- **Installable**: Add to Home Screen on iOS and Android.
- **Offline Capable**: Service Worker integration ensures access even without an internet connection.
- **Native Feel**: App-like experience with a custom manifest and splash screens.

---

## 🛠 Technology Stack

- **Framework**: [Laravel 12.x](https://laravel.com)
- **Tenancy**: [Stancl Tenancy](https://tenancyforlaravel.com/)
- **Frontend**: 
  - [Tailwind CSS v4](https://tailwindcss.com/)
  - [Blade Templates](https://laravel.com/docs/blade)
  - [Vite](https://vitejs.dev/) (Build tool)
- **Maps**: [Leaflet.js](https://leafletjs.com/)
- **Database**: SQLite (Development) / MySQL (Production)
- **PWA**: Custom Service Worker & Dynamic Manifest

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
   Create a symbolic link for storage to ensure images are accessible:
   ```bash
   php artisan storage:link
   ```

6. **Compile Assets**
   Using Vite for asset compilation:
   ```bash
   npm run build
   ```
   *For development with hot reload:*
   ```bash
   npm run dev
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```

---

## 📖 Usage & Documentation

### Accessing the Application
- **Central Landing Page**: `http://localhost:8000`
- **Genna Countdown**: `http://localhost:8000/genacountdown`
- **SuperAdmin Panel**: `http://localhost:8000/admin/login`
- **Tenant Admin Dashboard**: `http://<tenant-id>.localhost:8000/admin/timeline`

### Managing Tenants
Tenants are identified by their subdomain. For local development, ensure your hosts file or DNS setup supports subdomains like `tenant1.localhost`.

### Default Credentials (Seeders)

**SuperAdmin** (Central Management):
- Email: `superadmin@moments.app`
- Password: `password`

**Standard Admin**:
- Email: `admin@example.com`
- Password: `password`

**Tenant Users**:
- Email: `user1@tenant1.com`
- Email: `user2@tenant2.com`
- Password: `password`

---

## 📂 Project Structure

A high-level overview of the codebase:

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Tenant-specific admin logic
│   │   ├── SuperAdmin/      # Central management logic
│   │   └── Auth/            # Authentication handlers
│   ├── Models/              # Eloquent models
│   └── Providers/           # App service providers
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/             # Initial data (SuperAdmin, Tenants)
├── resources/views/
│   ├── admin/               # Tenant dashboard views
│   ├── superadmin/          # Central dashboard views
│   ├── layouts/             # Shared blade layouts
│   └── errors/              # Custom error pages
└── routes/
    ├── web.php              # Main application routes (Central & Tenant)
    └── tenant.php           # Dedicated tenancy routes (if separated)
```

---

## 🔧 Troubleshooting

| Issue | Solution |
| :--- | :--- |
| **Tenant Not Found (404)** | Ensure the subdomain matches a record in the `domains` table and your hosts file is configured. |
| **Database Connection Error** | Verify `DB_CONNECTION` and credentials in your `.env` file. |
| **PWA Not Installing** | Ensure you are accessing the site over HTTPS or `localhost`. |
| **Images Not Showing** | Run `php artisan storage:link` and check file permissions. |
| **Vite Manifest Not Found** | Run `npm run build` to generate the build assets. |

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
