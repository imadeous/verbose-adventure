# Custom Modern PHP MVC Framework
A lightweight, developer-friendly MVC framework for building web applications with PHP. Designed for minimal dependencies and resource efficiency, it features a powerful admin dashboard, database management tools, and is ready for deployment on shared hosting environments.


## Features

- **MVC Architecture**: Clean separation of concerns for organized and maintainable code.
- **Admin Dashboard**: A modern, responsive dashboard for managing your application.
- **Database Table Manager**: Create and view database tables directly from the admin interface.
- **CRUD Management**: Built-in, modern CRUD interfaces for managing Users and Products.
- **File Uploads & Avatars**: Robust helper for handling file uploads, used for user profile pictures.
- **Dynamic Breadcrumbs**: A simple helper for generating breadcrumbs to improve admin navigation.
- **Managed Tables API**: A small JSON API to dynamically manage which database tables are treated as resources in the admin UI.
- **Modular Site Analytics**: Installable feature to track page views, unique visitors, and more, with a Chart.js-powered dashboard and advanced reporting (date filters, device/country breakdown, error handling).
- **Role-Based Access Control**: Middleware and UI logic to restrict admin pages and features to authorized users only.
- **Dynamic UI**: Admin UI enhanced with Alpine.js for a more responsive and interactive experience.
- **Section-based Layouts**: A simple yet powerful view system using `@start`, `@yield` for clean templates.
- **Routing**: Simple and powerful routing system with support for controllers, dependency injection, and middleware.
- **Flash Messaging**: Session-based system for displaying success and error messages.
- **Security**: Built-in CSRF protection and middleware support.
- **Helpers**: Convenient functions for URL generation, file system pathing, and more.
- **Frontend**: Integrated Tailwind CSS and Alpine.js for modern UIs.

## Requirements

- PHP 8.0+
- MySQL
- Composer

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
   ```

   If you see errors about missing files in `vendor/` (such as `symfony/deprecation-contracts/function.php`), your `composer.json` may be missing required dependencies. Add any missing packages to your `composer.json` under a `require` section, then run:
   ```bash
   composer require symfony/deprecation-contracts
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure your database:**
   - Edit `config/database.php` with your database credentials.

4. **Set up your web server:**
   - Point your web server's document root to the `public` directory.
   - Ensure `mod_rewrite` (Apache) or equivalent is enabled.


## Usage

- **Define routes** in `routes/web.php`.
- **Create controllers** in `app/controllers`.
- **Create models** in `app/models`.
- **Create views** in `app/views`.

**Note:**
The provided models, controllers, routes, and views serve as syntax and architectural references. Future developers are encouraged to adapt, extend, or replace these components as needed to suit their own project requirements. The framework is intentionally designed to be flexible and developer-friendly, so you have full freedom to structure your application as you see fit.

## Acknowledgements & Vision

This project was born from a deep appreciation for the art of software development and a desire to look behind the curtain of modern PHP frameworks. While tools like Laravel offer immense power and convenience, there's a unique understanding that comes from building something from first principles. This framework is our journey to rediscover that "magic."

### Inspiration

Our primary inspiration comes from Laravel. We aim to capture a fraction of its elegance, developer-first ergonomics, and focus on making web development a creative and fulfilling experience. A heartfelt thank you to **Taylor Otwell** and the entire Laravel community for setting such a high standard and for continuously inspiring developers around the world.

### Our Philosophy & Target Audience

We are building this for the curious minds:
- **For the Learner:** If you're a student or a developer new to MVC, this framework provides a transparent look into how things work, without hidden complexities.
- **For the Pragmatist:** If you need a lightweight, no-nonsense foundation for a small-to-medium-sized project and want to avoid the overhead of larger frameworks, this is for you.
- **For the Craftsman:** If you are a developer who loves to tinker, customize, and have complete control over your toolset, you'll feel right at home.

### The Vision

Our vision is not to compete with the giants, but to carve a niche as an educational, transparent, and highly customizable tool. We want to empower developers to build beautiful, functional applications with a framework that is easy to understand, a joy to use, and simple to extend. It's about celebrating the craft of coding and providing a solid foundation for your next great idea.

## AI Collaboration Disclaimer

This project represents a deep collaboration between human developers and artificial intelligence. A significant portion of the architecture, code, and documentation was developed in partnership with **Gemini 2.5 Pro**, a large language model from Google.

The AI's role was not merely that of a tool, but of a creative and technical partner. Its contributions were integral to:
- **Architectural Design:** Brainstorming and refining the core MVC structure, the section-based view system, and the overall application flow.
- **Code Generation & Refactoring:** Writing boilerplate code, implementing complex features, modernizing legacy components, and refactoring for clarity and performance.
- **Problem Solving & Debugging:** Identifying subtle bugs, proposing solutions to complex errors, and offering alternative implementation strategies.
- **Documentation & Communication:** Articulating the project's vision, features, and documentation, including this very README.

This framework is a testament to a new paradigm of software development where human creativity is augmented by machine intelligence. It is a showcase of how AI can be leveraged not just for simple tasks, but as a genuine collaborator in the creative process of building software. We believe this partnership has resulted in a more robust, well-structured, and thoughtfully designed framework than could have been achieved alone.

As we move forward, we are committed to exploring the frontiers of this collaborative model, pushing the boundaries of what is possible when human and artificial minds work in concert.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
