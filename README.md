# Craftophile 3D Printing Platform

Craftophile is a modern PHP MVC web application for professional 3D printing services. It features a clean, responsive frontend (Tailwind CSS, Alpine.js), interactive stats, a gallery, and a streamlined order process.

## Features
- Custom PHP MVC framework
- Modern UI with Tailwind CSS & Alpine.js
- Animated stats and interactive carousels
- Professional content for machines, testimonials, and order process
- Modular controllers, models, and views
- Easy to extend and customize

## Getting Started

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL or compatible database
- Web server (Apache, Nginx, or XAMPP recommended)

### Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/imadeous/verbose-adventure.git
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Configure your database in `config/database.php`.
4. Set up your web server to serve the `public/` directory as the document root.
5. (Optional) Update environment variables in `Core/Env.php` as needed.

## Usage
- Access the site at `http://localhost/` (or your configured domain).
- Use the navigation bar to explore features: Gallery, Quote, About, Contact.
- Submit 3D print requests via the order form.

## Folder Structure
- `App/` — Controllers, Models, Views, Helpers, Middleware
- `Core/` — Framework core (Router, Controller, Model, View, Database)
- `public/` — Entry point and public assets
- `routes/` — Route definitions
- `themes/` — HTML themes and icon samples
- `config/` — Configuration files

## Customization
- Add new views in `App/Views/`
- Add controllers in `App/Controllers/`
- Update routes in `routes/web.php`

## License
MIT License. See `LICENSE` for details.

---
Craftophile — Professional 3D Printing, Made Simple.
