-- Migration: Remove price from products and create variants table
-- Date: 2025-12-07
-- Description: Refactor product pricing to use variants with dimensions, materials, and other attributes

-- Step 1: Create the variants table
CREATE TABLE IF NOT EXISTS variants (
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

-- Step 2: Migrate existing product prices to variants (if any products exist with prices)
-- This creates a default variant for each existing product
INSERT INTO variants (product_id, price, dimensions, material, finishing)
SELECT 
    id as product_id,
    price,
    'Standard' as dimensions,
    'Standard' as material,
    'Standard' as finishing
FROM products 
WHERE price IS NOT NULL AND price > 0;

-- Step 3: Remove the price column from products table
-- (Keeping this as a separate step in case you want to verify migration first)
-- ALTER TABLE products DROP COLUMN price;

-- Note: Uncomment the line above when you're ready to permanently remove the price column
-- For now, the price column remains in the products table for safety
