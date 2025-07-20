-- Database schema for Craftophile

-- USERS table already exists

-- QUOTES: customer quote requests
CREATE TABLE quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    instagram VARCHAR(100),
    delivery_address TEXT NOT NULL,
    billing_address TEXT,
    product_type VARCHAR(50) NOT NULL,
    material VARCHAR(50),
    quantity VARCHAR(20) NOT NULL,
    timeline VARCHAR(50) NOT NULL,
    description TEXT,
    budget VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- QUOTE_SERVICES: many-to-many for additional services per quote
CREATE TABLE quote_services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_id INT NOT NULL,
    service VARCHAR(50) NOT NULL,
    FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE CASCADE
);

-- GALLERY: gallery items
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CATEGORIES: for product categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- PRODUCTS: product types (optional, if you want to store more details)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    opened_at TIMESTAMP NULL DEFAULT NULL
);

-- PROMO_CODES: discount and promo code management
CREATE TABLE promo_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    type ENUM('percent','fixed') NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    valid_from DATE,
    valid_to DATE,
    usage_limit INT DEFAULT NULL,
    used_count INT DEFAULT 0,
    min_order_value DECIMAL(12,2) DEFAULT NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('income','expense') NOT NULL,
    category VARCHAR(100) NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    description TEXT,
    quote_id INT DEFAULT NULL,
    promo_code_id INT DEFAULT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE SET NULL,
    FOREIGN KEY (promo_code_id) REFERENCES promo_codes(id) ON DELETE SET NULL
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    quote_id INT,
    customer_name VARCHAR(100),
    customer_email VARCHAR(150),
    quality_rating TINYINT UNSIGNED NOT NULL CHECK (quality_rating BETWEEN 1 AND 5),
    pricing_rating TINYINT UNSIGNED NOT NULL CHECK (pricing_rating BETWEEN 1 AND 5),
    communication_rating TINYINT UNSIGNED NOT NULL CHECK (communication_rating BETWEEN 1 AND 5),
    packaging_rating TINYINT UNSIGNED NOT NULL CHECK (packaging_rating BETWEEN 1 AND 5),
    delivery_rating TINYINT UNSIGNED NOT NULL CHECK (delivery_rating BETWEEN 1 AND 5),
    recommendation_score TINYINT UNSIGNED NOT NULL CHECK (recommendation_score BETWEEN 0 AND 10),
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE SET NULL
);



