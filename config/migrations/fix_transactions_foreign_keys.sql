-- Fix foreign keys for transactions table
-- This script removes old foreign keys and recreates them with proper constraints

-- Step 1: Drop existing foreign keys (if they exist)
-- Note: Adjust the constraint names if they're different in your database
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS transactions_ibfk_1;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS transactions_ibfk_2;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS transactions_ibfk_3;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS transactions_ibfk_4;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS transactions_ibfk_5;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS fk_transactions_category;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS fk_transactions_product;
ALTER TABLE transactions DROP FOREIGN KEY IF EXISTS fk_transactions_variant;

-- Step 2: Ensure columns exist with correct data types
-- If category_id doesn't exist or is VARCHAR, this will fix it
ALTER TABLE transactions 
MODIFY COLUMN category_id INT DEFAULT NULL,
MODIFY COLUMN product_id INT DEFAULT NULL,
MODIFY COLUMN variant_id INT DEFAULT NULL;

-- Step 3: Add foreign key constraints with proper names
ALTER TABLE transactions
ADD CONSTRAINT fk_transactions_category 
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
ADD CONSTRAINT fk_transactions_product 
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
ADD CONSTRAINT fk_transactions_variant 
    FOREIGN KEY (variant_id) REFERENCES variants(id) ON DELETE SET NULL;

-- Step 4: Add indexes for better query performance
ALTER TABLE transactions
ADD INDEX IF NOT EXISTS idx_category_id (category_id),
ADD INDEX IF NOT EXISTS idx_product_id (product_id),
ADD INDEX IF NOT EXISTS idx_variant_id (variant_id),
ADD INDEX IF NOT EXISTS idx_date (date),
ADD INDEX IF NOT EXISTS idx_type (type);

-- Verify the foreign keys were created
SHOW CREATE TABLE transactions;
