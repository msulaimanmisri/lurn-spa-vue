# spa-vue

A modern full-stack Single Page Application (SPA) built with Laravel 12 and Vue 3, powered by Inertia.js and running on FrankenPHP with Laravel Octane in worker mode for optimal performance.

## 🚀 Tech Stack

### Backend
- **Laravel 12** - Modern PHP framework
- **Laravel Octane** - High-performance application server
- **FrankenPHP** - Go-powered PHP application server with Caddy
- **Inertia.js Laravel** - Server-side routing adapter
- **Laravel Breeze** - Authentication scaffolding
- **Laravel Sanctum** - API authentication
- **Ziggy** - JavaScript route helper

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **Inertia.js Vue 3** - Client-side adapter for seamless SPA experience
- **Tailwind CSS 3** - Utility-first CSS framework
- **Vite** - Fast build tool and dev server
- **Axios** - HTTP client

### Infrastructure
- **Docker** - Containerized development environment
- **MariaDB** - Relational database
- **Redis** - Caching and session storage
- **phpMyAdmin** - Database management UI

## 📋 Requirements

- Docker Desktop (or Docker Engine) with `docker compose`
- Node.js 18+ (LTS recommended) + npm
- PHP 8.2+ (for local development without Docker)

## ⚡ Quick Start (First Time Setup)

### 1. Clone and Configure Environment

```bash
git clone <repository-url>
cd spa-vue
cp .env.example .env
```

Edit `.env` and configure your database credentials and app settings.

### 2. Install Dependencies and Build Assets

```bash
# Install JavaScript dependencies
npm install

# Build frontend assets (required - public/build is gitignored)
npm run build
```

### 3. Build and Start Docker Services

```bash
# Build the Docker image
docker compose build

# Start database and Redis
docker compose up -d database redis

# Install PHP dependencies
docker compose run --rm app composer install

# Generate application key
docker compose run --rm app php artisan key:generate

# Run database migrations
docker compose run --rm app php artisan migrate
```

### 4. Start the Application

```bash
docker compose up -d
```

Access the application:
- **Main App**: http://localhost:8000
- **phpMyAdmin**: http://localhost:8080

## 🏗️ Project Structure

```
spa-vue/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Product/
│   │   │   │   ├── ProductIndexController.php
│   │   │   │   ├── ProductCreateController.php
│   │   │   │   └── ProductStoreController.php
│   │   │   ├── PublicPages/
│   │   │   └── ProfileController.php
│   │   └── Requests/
│   │       ├── StoreProductRequest.php
│   │       └── UpdateProductRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   └── Product.php
│   ├── Policies/
│   │   └── ProductPolicy.php
│   └── Providers/                
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   ├── Layouts/
│   │   ├── Pages/
│   │   │   ├── Auth/
│   │   │   ├── Products/
│   │   │   │   ├── ProductIndex.vue
│   │   │   │   └── ProductCreate.vue
│   │   │   ├── Profile/
│   │   │   ├── Dashboard.vue
│   │   │   ├── Home.vue
│   │   │   └── Welcome.vue
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── css/
│   └── views/
├── routes/
│   ├── web.php
│   ├── products.php
│   ├── auth.php
│   └── console.php
├── docker/
│   ├── Dockerfile
│   ├── frankenphp/
│   └── php/
├── database/
│   └── migrations/
│       └── 2025_12_31_061037_create_products_table.php
├── tests/
├── docker-compose.yml
├── vite.config.js
├── tailwind.config.js
└── composer.json
```

## 🔧 Architecture Overview

### FrankenPHP + Laravel Octane

This application uses FrankenPHP as the application server, running Laravel Octane in **worker mode** for exceptional performance:

- **Worker Mode**: Application boots once and handles multiple requests without reloading
- **Auto-reload**: Development mode watches for file changes (`--watch --poll`)
- **Performance**: Significantly faster than traditional PHP-FPM
- **HTTP/2 & HTTP/3**: Native support through Caddy
- **Automatic HTTPS**: Caddy handles SSL certificates automatically (in production)

Configuration in `docker-compose.yml`:
```yaml
command:
  - php
  - artisan
  - octane:frankenphp
  - --host=0.0.0.0
  - --port=8000
  - --workers=auto
  - --max-requests=500
  - --watch
  - --poll
```

### Inertia.js - The Monolith SPA

Inertia.js allows you to build SPAs without building an API:
- **Server-side routing**: Use Laravel routes (`routes/web.php`, `routes/products.php`)
- **Controller responses**: Return Inertia responses with data
- **Client-side rendering**: Vue components render the UI
- **Seamless navigation**: No full page reloads between pages
- **Shared data**: Pass data from Laravel to Vue components
- **Form handling**: Built-in form component with validation error handling

Example routing:
```php
// routes/products.php
Route::middleware(['auth'])->group(function () {
    Route::get('/products', ProductIndexController::class)->name('products.index');
    Route::get('/products/create', ProductCreateController::class)->name('products.create');
    Route::post('/products/store', ProductStoreController::class)->name('products.store');
});
```

Example controller:
```php
// ProductIndexController.php
public function __invoke(#[CurrentUser] User $user): Response
{
    return Inertia::render('Products/ProductIndex', [
        'user' => $user,
    ]);
}
```

Example Vue form with Inertia:
```vue
<Form :action="route('products.store')" method="post" #default="{ errors, processing }">
    <TextInput name="name" />
    <InputError :message="errors.name" />
</Form>
```

## 🛠️ Development

### Using Docker (Recommended)

**Start development environment:**
```bash
docker compose up -d
```

**Watch logs:**
```bash
docker compose logs -f app
```

**Run Artisan commands:**
```bash
docker compose exec app php artisan [command]
```

**Access container shell:**
```bash
docker compose exec app bash
```

### Local Development (Without Docker)

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Start development servers
composer run dev
# This runs: Laravel server + Vite dev server concurrently
```

### Building Frontend Assets

**Development (with hot reload):**
```bash
npm run dev
```

**Production build:**
```bash
npm run build
```

## 🎯 Common Tasks

### Database Operations

```bash
# Run migrations
docker compose exec app php artisan migrate

# Rollback migrations
docker compose exec app php artisan migrate:rollback

# Seed database
docker compose exec app php artisan db:seed

# Fresh migration with seed
docker compose exec app php artisan migrate:fresh --seed

# Create new migration
docker compose exec app php artisan make:migration create_table_name

# Create new model with migration
docker compose exec app php artisan make:model ModelName -m
```

### Cache Management

```bash
# Clear all caches
docker compose exec app php artisan optimize:clear

# Cache configuration
docker compose exec app php artisan config:cache

# Cache routes
docker compose exec app php artisan route:cache

# Cache views
docker compose exec app php artisan view:cache
```

### Code Quality

```bash
# Format PHP code (Laravel Pint)
docker compose exec app vendor/bin/pint

# Run tests
docker compose exec app php artisan test

# Run specific test
docker compose exec app php artisan test --filter=TestName
```

### Artisan Generators

```bash
# Create controller (single action)
docker compose exec app php artisan make:controller Product/ProductIndexController --invokable

# Create form request
docker compose exec app php artisan make:request StoreProductRequest

# Create policy
docker compose exec app php artisan make:policy ProductPolicy --model=Product

# Create model with extras
docker compose exec app php artisan make:model Product -mfsc
# -m (migration), -f (factory), -s (seeder), -c (controller)
```

### Docker Operations

```bash
# Stop all services
docker compose down

# Stop and remove volumes (caution: deletes database)
docker compose down -v

# Rebuild containers
docker compose build --no-cache

# Restart specific service
docker compose restart app

# Force recreate (useful after .env changes)
docker compose up -d --force-recreate app

# View resource usage
docker compose stats
```

## 📦 Available Services

| Service | Port | Description |
|---------|------|-------------|
| app | 8000 | Laravel application (FrankenPHP) |
| database | 3306 | MariaDB database |
| redis | 6379 | Redis cache/session store |
| phpmyadmin | 8080 | Database management interface |

### Service Configuration

**App Container:**
- Image: `dunglas/frankenphp:1.11.1-php8.4-bookworm`
- PHP Extensions: pdo_mysql, mbstring, zip, exif, pcntl, gd, opcache, intl, redis
- User: www (UID 1000)
- Working Directory: `/app`

**Database:**
- Image: `mariadb:latest`
- Persistent storage: `mariadb_data` volume

**Redis:**
- Image: `redis:alpine`

## 🔐 Authentication

This project includes Laravel Breeze authentication scaffolding with Inertia + Vue:

**Available Routes:**
- `/` - Homepage (public)
- `/login` - User login
- `/register` - New user registration
- `/forgot-password` - Password reset request
- `/reset-password` - Password reset form
- `/verify-email` - Email verification
- `/confirm-password` - Password confirmation
- `/profile` - User profile management (edit, password, delete)
- `/dashboard` - Authenticated user dashboard

## 📦 Product Management Feature

The application includes a complete CRUD product management system with:

### Database Schema

**Products Table:**
```sql
- id (primary key)
- name (string, required)
- description (text, nullable)
- price (decimal 10,2, required)
- status (string: 'active'|'inactive', default: 'active')
- timestamps
```

### Available Routes

All product routes are protected by `auth` middleware:

| Method | URI | Name | Controller | Description |
|--------|-----|------|------------|-------------|
| GET | `/products` | products.index | ProductIndexController | List all products |
| GET | `/products/create` | products.create | ProductCreateController | Show create form |
| POST | `/products/store` | products.store | ProductStoreController | Store new product |
| GET | `/products/{product}/edit` | products.edit | ProductEditController | Show edit form |
| PUT | `/products/{product}` | products.update | ProductUpdateController | Update product |
| DELETE | `/products/{product}` | products.delete | ProductDeleteController | Delete product |

### Controllers Architecture

This project uses **Single Action Controllers** for better organization:

- `ProductIndexController` - Displays product listing with all products
- `ProductCreateController` - Renders product creation form
- `ProductStoreController` - Handles product creation with validation
- `ProductEditController` - Renders product edit form with pre-filled data
- `ProductUpdateController` - Handles product update with validation
- `ProductDeleteController` - Handles product deletion with route model binding

### Form Request Validation

**StoreProductRequest:**
```php
'name' => ['required', 'string', 'max:255']
'description' => ['nullable', 'string']
'price' => ['required', 'numeric', 'min:0']
'status' => ['required', 'in:active,inactive']
```

**UpdateProductRequest:**
Same rules as StoreProductRequest (prepared for future update functionality)

### Vue Components

- **ProductIndex.vue** - Product listing page with:
  - Responsive table showing all products
  - ID, Name, Description, Price, Status columns
  - Status badge with color coding (green for active, red for inactive)
  - Price formatted to 2 decimal places
  - Edit and Delete action buttons
  - Delete confirmation dialog
  - Empty state message when no products exist
  - Links to edit and delete product routes

- **ProductCreate.vue** - Product creation form with:
  - Form fields: Name, Description, Price, Status
  - Real-time validation error display
  - Submit button integrated with form
  - POST request to products.store route

- **ProductEdit.vue** - Product edit form with:
  - Pre-filled form fields from product data
  - Form fields: Name, Description, Price, Status
  - Real-time validation error display
  - Submit button for updating product
  - PUT request to products.update route
  - Selected status option displays correctly

### Policy-Based Authorization

`ProductPolicy` is configured for future authorization implementation:
- `viewAny()` - View product list
- `view()` - View single product
- `create()` - Create new product
- `update()` - Edit existing product
- `delete()` - Delete product
- `restore()` - Restore soft-deleted product
- `forceDelete()` - Permanently delete product

**Note:** All policies currently return `false` - implement as needed for your use case.

## 🎨 Frontend Components

### Layouts
- `GuestLayout.vue` - For unauthenticated pages (used in Home page)
- `AuthenticatedLayout.vue` - For authenticated pages with navigation

### Reusable Components
- Form elements: TextInput, Checkbox, InputLabel, InputError
- Buttons: PrimaryButton, SecondaryButton, DangerButton
- Navigation: NavLink, ResponsiveNavLink, Dropdown, DropdownLink
- UI: Modal, ApplicationLogo

### Pages

**Public Pages:**
- Welcome.vue - Landing page
- Home.vue - Homepage with login/register links (uses GuestLayout)

**Authentication Pages:**
- Login.vue - User login form
- Register.vue - User registration form
- ForgotPassword.vue - Password reset request
- ResetPassword.vue - Password reset form
- ConfirmPassword.vue - Password confirmation
- VerifyEmail.vue - Email verification

**User Pages:**
- Dashboard.vue - Main dashboard after login
- Profile/Edit.vue - Profile management page
- Profile/Partials/UpdateProfileInformationForm.vue
- Profile/Partials/UpdatePasswordForm.vue
- Profile/Partials/DeleteUserForm.vue

**Product Pages:**
- Products/ProductIndex.vue - Product listing with actions
- Products/ProductCreate.vue - Product creation form with Inertia Form component

## 🐛 Troubleshooting

### Vite Manifest Error
**Problem:** Missing `public/build/manifest.json`

**Solution:**
```bash
npm run build
```

### Changes Not Reflecting
**Problem:** `.env` changes not picked up

**Solution:** Restart Octane workers
```bash
docker compose up -d --force-recreate app
```

### Database Connection Issues
**Problem:** Cannot connect to database

**Solution:**
1. Ensure database service is running: `docker compose ps`
2. Check `.env` credentials match `docker-compose.yml`
3. Wait for database to fully initialize on first run

### Port Already in Use
**Problem:** Port 8000 or 8080 already in use

**Solution:** Edit `docker-compose.yml` to change port mappings:
```yaml
ports:
  - "8001:8000"  # Change 8000 to 8001
```

### Permission Issues
**Problem:** Permission denied errors

**Solution:**
```bash
# Fix storage and cache permissions
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app chown -R www:www storage bootstrap/cache
```

## 🧪 Testing

```bash
# Run all tests
docker compose exec app php artisan test

# Run tests with coverage
docker compose exec app php artisan test --coverage

# Run specific test suite
docker compose exec app php artisan test --testsuite=Feature

# Run tests in parallel
docker compose exec app php artisan test --parallel
```

## 📝 Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="spa-vue"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=spavue
DB_USERNAME=root
DB_PASSWORD=secret

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=redis
REDIS_PORT=6379
```

## 🚀 Deployment

### Production Build

```bash
# Build assets for production
npm run build

# Optimize Laravel
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan event:cache
```

### Production Environment
- Set `APP_ENV=production` and `APP_DEBUG=false`
- Use proper database credentials
- Configure queue workers
- Set up SSL certificates
- Enable Redis for cache/sessions
- Remove `--watch --poll` from Octane command

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📚 Resources & References

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [FrankenPHP Documentation](https://frankenphp.dev/)
- [Laravel Octane Documentation](https://laravel.com/docs/octane)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Original Course](https://www.udemy.com/course/master-laravel-6-with-vuejs-fullstack-development)

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
