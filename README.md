# BirthDay App

A Laravel PWA application with countdown landing page and admin dashboard for managing moments/memories.

## Features

- **Landing Page**: Stranger Things themed countdown timer with video background
- **Admin Dashboard**: Mobile-first design with bottom navigation
  - **Timeline**: Chronological view of moments grouped by date
  - **Calendar**: Monthly calendar with moment indicators
  - **Map**: Interactive Leaflet map showing moment locations
  - **Settings**: Profile management, preferences, and logout
- **PWA Support**: Service worker, manifest, install prompts for mobile/desktop
- **Authentication**: Secure admin login system

## Requirements

- PHP 8.2+
- MySQL 5.7+
- Composer
- XAMPP (or similar local server)

## Installation

1. **Database Setup**:
   ```bash
   # Create database (using XAMPP MySQL)
   c:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS birthday_app;"
   ```

2. **Environment Configuration**:
   The `.env` file is pre-configured for XAMPP MySQL:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=birthday_app
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Run Migrations & Seed**:
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Create Storage Link**:
   ```bash
   php artisan storage:link
   ```

5. **Start Server**:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

## Default Admin Credentials

- **Email**: admin@example.com
- **Password**: password

## Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Admin controllers (Timeline, Calendar, Map, Settings, Moment)
│   │   ├── Auth/            # Authentication controller
│   │   └── LandingController.php
│   └── Models/              # Moment, MomentImage, Setting models
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/             # Admin user and sample data
├── public/
│   ├── icons/               # PWA icons
│   └── sw.js                # Service worker
├── resources/views/
│   ├── admin/               # Admin dashboard views
│   ├── auth/                # Login view
│   ├── layouts/             # Layout templates
│   └── landing.blade.php    # Landing page
└── routes/web.php           # Application routes
```

## URLs

- **Landing Page**: http://localhost:8000/
- **Admin Login**: http://localhost:8000/login
- **Admin Dashboard**: http://localhost:8000/admin/timeline

## PWA Installation

The app will prompt users to install as a PWA on supported browsers. On iOS, users can add to home screen via Safari's share menu.

## License

MIT License
