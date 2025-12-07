-- Migration: Restructure transactions table to support category, product, and variant tracking
-- This allows for detailed analytics while keeping fields nullable for non-product transactions

-- Add new columns for better tracking
ALTER TABLE transactions 
ADD COLUMN product_id INT DEFAULT NULL AFTER category,
ADD COLUMN variant_id INT DEFAULT NULL AFTER product_id;

-- Rename category column to category_id for consistency
-- Note: If you have existing data with category as VARCHAR, you'll need to migrate it first
-- For now, we'll assume category can be changed to category_id
ALTER TABLE transactions 
CHANGE COLUMN category category_id INT DEFAULT NULL;

-- Add foreign key constraints
ALTER TABLE transactions
ADD CONSTRAINT fk_transactions_category 
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
ADD CONSTRAINT fk_transactions_product 
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
ADD CONSTRAINT fk_transactions_variant 
    FOREIGN KEY (variant_id) REFERENCES variants(id) ON DELETE SET NULL;

-- Add indexes for better query performance
ALTER TABLE transactions
ADD INDEX idx_category_id (category_id),
ADD INDEX idx_product_id (product_id),
ADD INDEX idx_variant_id (variant_id),
ADD INDEX idx_date (date),
ADD INDEX idx_type (type);

-- The final structure will be:
-- transactions (
--   id, 
--   type,                 -- income/expense
--   category_id,          -- nullable - references categories table
--   product_id,           -- nullable - references products table  
--   variant_id,           -- nullable - references variants table
--   amount,
--   description,          -- free-form text for additional details
--   quote_id,             -- nullable - references quotes table
--   promo_code_id,        -- nullable - references promo_codes table
--   date,
--   created_at
-- )
