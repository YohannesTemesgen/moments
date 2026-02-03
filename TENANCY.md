# Multi-Tenancy Documentation

This application uses a multi-tenant architecture with a **single shared database**. Data isolation is achieved through a `tenant_id` column and Laravel's global scopes.

## Architecture
- **Package**: `stancl/tenancy`
- **Isolation**: Single shared database with `tenant_id` scoping.
- **Identification**: Subdomain/Domain routing.

## Adding a New Tenant Dynamically

To add a new tenant, you can use the `Tenant` and `Domain` models.

### Via Tinker or Code
```php
// Create the tenant
$tenant = App\Models\Tenant::create(['id' => 'mytenant']);

// Assign a domain or subdomain
$tenant->domains()->create(['domain' => 'mytenant.localhost']);

// Create an initial user for the tenant
App\Models\User::create([
    'tenant_id' => 'mytenant',
    'name' => 'Admin User',
    'email' => 'admin@mytenant.com',
    'password' => Hash::make('secret-password'),
]);
```

### Via SuperAdmin Panel
The SuperAdmin panel (`/admin/login` for superadmins) is designed to manage tenants and their users centrally.

## Development Setup
When developing locally, you can use subdomains like `tenant1.localhost`. Ensure your local environment (like XAMPP/Apache) is configured to handle these subdomains if you're not using `php artisan serve`.

## Tenant-Aware Models
All models that need data isolation must use the `Stancl\Tenancy\Database\Concerns\BelongsToTenant` trait.

Current tenant-aware models:
- `User`
- `Moment`
- `MomentImage`
- `NavItem`
- `Setting`

## Database Migrations
When adding new tables that need to be tenant-aware:
1. Include a `tenant_id` column: `$table->string('tenant_id')->nullable();`
2. Add a foreign key to the `tenants` table.
3. Use the `BelongsToTenant` trait in the corresponding Eloquent model.

## Deployment Process
1. Run `php artisan migrate` to ensure the `tenants` and `domains` tables are created.
2. Ensure your web server is configured with a wildcard SSL and wildcard DNS (e.g., `*.yourdomain.com`) to support dynamic subdomains.
3. Use the SuperAdmin dashboard to provision new tenants as needed.
