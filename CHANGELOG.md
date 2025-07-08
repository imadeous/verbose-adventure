# [1.3.2] - 2025-07-05

### Added
- **Site Analytics Dashboard**: Integrated advanced reporting and visualization using Report and Chart helpers. Added date filtering, unique visitor count, and robust error handling for analytics.
- **Database Layer**: Fixed all model/query errors by ensuring QueryBuilder methods (`where`, `table`, `setModel`, etc.) are present and namespace is correct.

### Fixed
- **Namespace/Autoloading**: Fixed all PHP namespace and autoloading issues in helpers and database classes.
- **Fatal Errors**: Resolved all undefined method and property errors in the database/model layer.

### Changed
- **README/TODO**: Updated documentation to reflect new analytics and reporting features.
# Changelog

## [1.3.1] - 2025-07-05

### Changed
- **Role-Based Access Control**: Added `RoleMiddleware` and updated router to support middleware, protecting all admin routes and UI from unauthorized access.
- **File Pathing**: Replaced all remaining `base_path()` usages with `project_root()` for file system access, fixing all file upload and config path issues.
- **Admin UI**: Refactored admin header and user avatar logic to use a new `storage_url()` helper and improved the `User` model for correct avatar display.
- **SettingsController**: Fixed all file path, config, and managed tables issues by using correct helpers and structure.
- **General Refactoring**: Improved maintainability and modularity of controllers, helpers, and views.

### Fixed
- **Authentication Bugs**: Fixed all login/logout, double-hashing, and session issues. Improved error feedback and flash messaging throughout the admin UI.
- **UI Hiding**: Ensured users with role = 'user' cannot see or access admin-only pages or UI elements.
- **File Uploads**: Fixed all file upload and avatar pathing bugs.

### Removed
- **General Site Settings UI**: Rolled back the per-user general site settings feature and UI from the settings page.

## [1.3.0] - 2025-07-04

### Added
- **File Uploads & Management**: Implemented a robust `File.php` helper class to handle file uploads, deletions, and metadata retrieval with robust error handling.
- **User Profile Pictures**: Added functionality for users to upload and manage their own profile avatars on a dedicated profile page (`/admin/profile`). Includes a default SVG avatar.
- **Dynamic Breadcrumbs**: Created a `Breadcrumb.php` helper to easily generate and display breadcrumbs throughout the admin panel, improving navigation.
- **Managed Tables API**: Overhauled the "Managed Tables" feature into a small API. It now reads from `config/managed_tables.json` and provides an endpoint (`/api/managed-tables`) to get all database tables and the current managed list.
- **Flash Messaging Partial**: Created a dedicated partial for flash messages (`_flash.view.php`) and included it in the main admin layout for consistent feedback.

### Changed
- **API-Driven UI**: Refactored the "Managed Tables" settings page and the admin sidebar to be fully dynamic. Both now use Alpine.js to fetch data from the new API endpoint, ensuring the UI is always in sync with the configuration.
- **Global Helpers**: Updated `composer.json` to autoload all helper files, making functions like `url()` and `project_root()` globally available without manual `require` statements.
- **Pathing & Stability**: Replaced all instances of `base_path()` with a more reliable `project_root()` helper to fix critical file permission and pathing errors, especially for file uploads.
- **Product Routes**: Refactored product routes from resourceful to explicit definitions to resolve routing conflicts and 404 errors.

### Fixed
- **File Upload Permissions**: Resolved persistent "Permission denied" errors during file uploads by correcting storage path logic in the `File.php` helper.
- **Undefined Functions**: Eliminated fatal errors caused by unavailable helper functions by ensuring they are properly autoloaded by Composer.

## [1.2.0] - 2025-07-04

### Added
- **Modular Site Analytics**: Created a fully modular Site Analytics feature that can be installed and configured from a new "Settings" page in the admin panel.
- **Analytics Dashboard**: Implemented an analytics dashboard with a Chart.js visualization and a raw data table.
- **Full CRUD for Users & Products**: Built complete Create, Read, Update, and Delete functionality for Users and Products.
- **Dynamic UI with Alpine.js**: Enhanced the settings form with Alpine.js to dynamically show/hide elements based on user interaction.
- **Database-Driven UI State**: The analytics settings UI now checks for the existence of the `site_analytics` table to show an "Enabled" status, preventing misconfiguration.
- **Dynamic Sidebar Link**: The "Site Analytics" link in the admin sidebar now appears only after the feature has been successfully installed.

### Changed
- **Unified Admin UI**: Standardized all admin CRUD views (Users, Products, Tables) with a consistent, modern Tailwind CSS layout and SVG icons.
- **Refactored Admin Sidebar**: Overhauled the sidebar for a more compact, resource-driven layout.
- **Consolidated Analytics Logic**: Moved all analytics configuration and dashboard logic into a new `SettingsController`, cleaning up routes and old controllers.
- **Improved Configuration**: Analytics settings are now stored in `config/features/analytics.json`, allowing for more complex feature management.

### Fixed
- **Layout & Styling**: Corrected various padding, margin, and alignment issues across the admin dashboard, especially in the sidebar.
- **Form Handling**: Improved form submission logic and CSRF token verification in the settings panel.
- **URL Generation**: Ensured the `url()` helper is used consistently to avoid routing issues.

### Removed
- **Old Analytics Files**: Deleted the previous `AnalyticsController` and associated views, as they are now redundant.

## [1.1.0] - 2025-07-02

### Added
- Modern, section-based view rendering system (`@start`, `@yield`).
- Comprehensive admin dashboard for managing application data.
- UI for creating and managing database tables directly from the admin panel.
- Session-based flash messaging system for user feedback (success/error messages).
- `url()` and `base_path()` helper functions for robust URL generation.
- Detailed table information view (engine, row count, size) using `information_schema`.

### Changed
- Unified all pages under a consistent, modern layout system.
- Aligned entire admin area with the `dashboard.html` theme.
- Replaced legacy view rendering with the new section-based system.
- Refactored `Core\Request` methods to be static for easier access.
- Improved router to handle controller dependency injection and 404s gracefully.
- Updated all views and redirects to use the new `url()` helper, fixing subdirectory deployment issues.

### Removed
- Deprecated and completely removed the entire database migration system.
- Deleted all migration-related files, routes, controllers, and views.

### Fixed
- Resolved numerous blank page and layout/content rendering bugs.
- Corrected 404 errors caused by incorrect URL generation and routing.
- Fixed various fatal errors (argument counts, static access, undefined variables).

## [1.0.0] - 2025-07-01

### Added

- Initial release of the framework.
- Core MVC components.
- Routing system.
- Basic ORM.
- CSRF protection.
- Helper functions.
- Tailwind CSS and Alpine.js integration.
