# AGENTS.md

This file provides guidelines for agentic coding assistants working in this Laravel 12 + Livewire 4 + Flux UI project.

## Project Overview

- **Framework**: Laravel 12.0 (PHP 8.2+)
- **Frontend**: Livewire 4.0 with Flux 2.9 UI components
- **Styling**: Tailwind CSS 4.0
- **Testing**: Pest 4.4
- **Code Quality**: Laravel Pint for linting
- **Build Tool**: Vite 7.0

## Commands

### Development
```bash
npm run dev          # Start Vite dev server (with HMR)
npm run build        # Build assets for production
composer dev         # Full dev stack: artisan serve + queue + logs + vite
```

### Code Quality
```bash
composer lint        # Run Pint to fix code style
composer lint:check  # Check code style without fixing
composer test        # Full CI: lint check + run tests
./vendor/bin/pest    # Run all tests
```

### Running Tests
```bash
# Run specific test file
./vendor/bin/pest tests/Feature/DashboardTest.php

# Run single test by name (exact match)
./vendor/bin/pest tests/Feature/DashboardTest.php --filter "guests are redirected"

# Run tests with filter pattern
./vendor/bin/pest --filter "authentication"
```

## PHP Code Style

### General
- Use Laravel Pint preset (configured in pint.json)
- Follow PSR-4 autoloading (App\ namespace → app/ directory)
- Use type declarations on all return types
- Use PHPDoc for complex array types with `@return array<string, Type>`

### Imports & Namespaces
- Order: external libraries, then internal (use App\...)
- Prefer built-in Laravel facades over helper functions
- Use `use Illuminate\Support\Facades\` explicitly

### Type Hints
```php
// Use short array syntax
protected function passwordRules(): array

// Use typed arrays with generics
public function create(array $input): User

// Use short closures for callbacks
fn ($word) => Str::substr($word, 0, 1)
```

### Naming Conventions
- **Classes**: PascalCase (CreateNewUser, PasswordValidationRules)
- **Methods**: camelCase (createUser, passwordRules)
- **Variables**: camelCase ($userId, $userName)
- **Constants**: UPPER_SNAKE_CASE
- **Database**: snake_case (users_table, password_reset_tokens)

### Traits & Concerns
- Use traits for shared validation rules (e.g., PasswordValidationRules, ProfileValidationRules)
- Place traits in `app/Concerns/` directory
- Use trait methods instead of duplicating validation arrays

### Error Handling
- Use Laravel's built-in validation (Validator facade)
- Return typed User models from creation methods
- Use proper HTTP status codes in tests (assertOk, assertRedirect)

## Testing (Pest)

### Test Structure
```php
test('descriptive test name', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $response = $this->actingAs($user)->get(route('dashboard'));

    // Assert
    $response->assertOk();
});
```

### Pest Patterns
- Use `test()` function instead of `it()` or `test()` class methods
- Use `expect()` for assertions when checking values
- Use `$this->actingAs($user)` for authenticated requests
- Use `Livewire::test('component.name')` for Livewire components
- Use RefreshDatabase trait in tests/Pest.php for Feature tests

### Test Organization
- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`
- Organize by feature: `tests/Feature/Auth/`, `tests/Feature/Settings/`
- Use descriptive test names that explain what's being tested

## Frontend (Blade & Livewire)

### Livewire Components
- Use Flux UI components for forms and UI elements
- Prefix Livewire component files with `⚡` (e.g., `⚡profile.blade.php`)
- Reference components with namespace: `pages::settings.profile`
- Use data binding for forms: `[data-flux-field]`

### Blade Templates
- Use `@source` directive for component scanning
- Use `@theme` for design tokens in CSS
- Use `@layer` for organizing CSS layers
- Import Flux CSS: `@import '../../vendor/livewire/flux/dist/flux.css'`

### Tailwind CSS
- Use Tailwind 4.0 syntax with `@import 'tailwindcss'`
- Define custom variants with `@custom-variant`
- Use CSS variables for theming in `@theme` block

## Routing

### Route Organization
- Group routes by middleware (auth, verified)
- Use descriptive route names (profile.edit, security.edit)
- Separate route files by feature (settings.php)
- Use `Route::redirect()` for simple redirects

### Route Patterns
```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::livewire('settings/profile', 'pages::settings.profile')->name('profile.edit');
```

## Database

### Migrations
- Use timestamp format: YYYY_MM_DD_HHMMSS_description.php
- Use snake_case for table and column names
- Add foreign keys with proper indexes
- Include both up() and down() methods

### Models
- Use `HasFactory` trait with typed factory: `@use HasFactory<UserFactory>`
- Define `$fillable` properties as arrays
- Use `$hidden` for sensitive fields
- Use `casts()` method for type casting (return array)
- Add helper methods on models for common operations

## Best Practices

1. **Always run lint before committing**: `composer lint`
2. **Run tests before pushing**: `composer test` or `./vendor/bin/pest`
3. **Use type hints** on all methods and parameters
4. **Keep components small** - split large Livewire components into smaller pieces
5. **Use factories** for test data creation
6. **Follow Laravel conventions** - don't reinvent the wheel
7. **Use environment variables** for configuration (never hardcode credentials)
8. **Write descriptive commit messages** and test names

## File Structure Reference

- `app/Actions/` - Action classes (Fortify, etc.)
- `app/Concerns/` - Shared traits (validation rules, etc.)
- `app/Http/Controllers/` - Traditional controllers
- `app/Livewire/` - Livewire components and actions
- `app/Models/` - Eloquent models
- `app/Providers/` - Service providers
- `database/migrations/` - Database migrations
- `database/factories/` - Model factories
- `resources/views/` - Blade templates (pages, layouts, components)
- `resources/css/` - Stylesheets (Tailwind)
- `resources/js/` - JavaScript (Vite entry point)
- `routes/` - Route definitions (web.php, console.php, etc.)
- `tests/` - Pest tests (Feature, Unit)
