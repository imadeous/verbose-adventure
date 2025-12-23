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
    caption TEXT NULL,
    image_type ENUM('site','category','product') NOT NULL,
    related_id INT(11) NULL,
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- VARIANTS: product variants with dimensions, materials, pricing, etc.
CREATE TABLE variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    dimensions VARCHAR(255) NULL COMMENT 'User-defined dimensions (e.g., "2x3x8 cm", "8\" wingspan", "6\" tall")',
    weight INT NULL COMMENT 'Weight in grams',
    material VARCHAR(255) NULL COMMENT 'Material description (user-defined)',
    color VARCHAR(7) NULL COMMENT 'Hex color code (e.g., "#FF5733")',
    finishing VARCHAR(255) NULL COMMENT 'Finishing description (e.g., "raw print", "sanded", "painted", "full post production")',
    assembly_required BOOLEAN DEFAULT FALSE COMMENT 'Whether assembly is required',
    price DECIMAL(10,2) NOT NULL COMMENT 'Price for this variant',
    sku VARCHAR(100) NULL COMMENT 'Stock Keeping Unit (optional)',
    stock_quantity INT DEFAULT 0 COMMENT 'Available stock quantity',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_id (product_id),
    INDEX idx_price (price)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
    category_id INT DEFAULT NULL COMMENT 'References categories table - for categorizing transactions',
    product_id INT DEFAULT NULL COMMENT 'References products table - for product-related transactions',
    variant_id INT DEFAULT NULL COMMENT 'References variants table - specific variant sold',
    amount DECIMAL(12,2) NOT NULL,
    description TEXT COMMENT 'Additional details about the transaction',
    quote_id INT DEFAULT NULL,
    promo_code_id INT DEFAULT NULL,
    platform VARCHAR(50) DEFAULT NULL COMMENT 'Platform where transaction originated (e.g., whatsapp, instagram, website)',
    customer_username VARCHAR(100) DEFAULT NULL COMMENT 'Customer username or identifier',
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    FOREIGN KEY (variant_id) REFERENCES variants(id) ON DELETE SET NULL,
    FOREIGN KEY (quote_id) REFERENCES quotes(id) ON DELETE SET NULL,
    FOREIGN KEY (promo_code_id) REFERENCES promo_codes(id) ON DELETE SET NULL,
    INDEX idx_type (type),
    INDEX idx_category_id (category_id),
    INDEX idx_product_id (product_id),
    INDEX idx_variant_id (variant_id),
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tracks all financial transactions including sales, expenses, and other income';

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



