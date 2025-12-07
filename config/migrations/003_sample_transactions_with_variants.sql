-- Sample transactions with variant tracking
-- IMPORTANT: Before running this, you MUST check your actual variant IDs!
-- Run this query first to get your variant IDs:
-- SELECT v.id, v.product_id, p.name as product_name, v.sku, v.price 
-- FROM variants v 
-- JOIN products p ON v.product_id = p.id 
-- WHERE v.product_id IN (1,2,3,5,7,8)
-- ORDER BY v.product_id, v.id;

-- Then replace the variant_id values below with your actual variant IDs
-- If you don't have variants for these products yet, create them first!

-- OPTION 1: Simple version - use NULL for variant_id if you don't have variants yet
-- This will still track product_id for analytics

-- Bulk insert transactions WITHOUT variant tracking (if variants don't exist yet)
INSERT INTO transactions (type, category_id, product_id, variant_id, amount, description, date) VALUES
-- Product 1 transactions
('income', NULL, 1, NULL, 45.99, 'Online order #1001', DATE_SUB(CURDATE(), INTERVAL 60 DAY)),
('income', NULL, 1, NULL, 52.50, 'Online order #1002', DATE_SUB(CURDATE(), INTERVAL 58 DAY)),
('income', NULL, 1, NULL, 45.99, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 55 DAY)),
('income', NULL, 1, NULL, 48.75, 'Online order #1003', DATE_SUB(CURDATE(), INTERVAL 52 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1004', DATE_SUB(CURDATE(), INTERVAL 50 DAY)),
('income', NULL, 1, NULL, 52.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 48 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1005', DATE_SUB(CURDATE(), INTERVAL 45 DAY)),
('income', NULL, 1, NULL, 48.75, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 42 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1006', DATE_SUB(CURDATE(), INTERVAL 40 DAY)),
('income', NULL, 1, NULL, 52.50, 'Online order #1007', DATE_SUB(CURDATE(), INTERVAL 38 DAY)),
('income', NULL, 1, NULL, 45.99, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 35 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1008', DATE_SUB(CURDATE(), INTERVAL 32 DAY)),
('income', NULL, 1, NULL, 52.50, 'Online order #1009', DATE_SUB(CURDATE(), INTERVAL 28 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1010', DATE_SUB(CURDATE(), INTERVAL 25 DAY)),
('income', NULL, 1, NULL, 48.75, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 22 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1011', DATE_SUB(CURDATE(), INTERVAL 18 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1012', DATE_SUB(CURDATE(), INTERVAL 15 DAY)),
('income', NULL, 1, NULL, 52.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 12 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1013', DATE_SUB(CURDATE(), INTERVAL 8 DAY)),
('income', NULL, 1, NULL, 45.99, 'Online order #1014', DATE_SUB(CURDATE(), INTERVAL 5 DAY)),

-- Product 2 transactions
('income', NULL, 2, NULL, 89.99, 'Online order #2001', DATE_SUB(CURDATE(), INTERVAL 59 DAY)),
('income', NULL, 2, NULL, 95.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 57 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2002', DATE_SUB(CURDATE(), INTERVAL 54 DAY)),
('income', NULL, 2, NULL, 92.50, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 51 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2003', DATE_SUB(CURDATE(), INTERVAL 49 DAY)),
('income', NULL, 2, NULL, 95.00, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 46 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2004', DATE_SUB(CURDATE(), INTERVAL 43 DAY)),
('income', NULL, 2, NULL, 92.50, 'Online order #2005', DATE_SUB(CURDATE(), INTERVAL 41 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2006', DATE_SUB(CURDATE(), INTERVAL 39 DAY)),
('income', NULL, 2, NULL, 95.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 36 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2007', DATE_SUB(CURDATE(), INTERVAL 33 DAY)),
('income', NULL, 2, NULL, 89.99, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 30 DAY)),
('income', NULL, 2, NULL, 95.00, 'Online order #2008', DATE_SUB(CURDATE(), INTERVAL 27 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2009', DATE_SUB(CURDATE(), INTERVAL 24 DAY)),
('income', NULL, 2, NULL, 92.50, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 20 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2010', DATE_SUB(CURDATE(), INTERVAL 17 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2011', DATE_SUB(CURDATE(), INTERVAL 13 DAY)),
('income', NULL, 2, NULL, 95.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 10 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2012', DATE_SUB(CURDATE(), INTERVAL 6 DAY)),
('income', NULL, 2, NULL, 89.99, 'Online order #2013', DATE_SUB(CURDATE(), INTERVAL 3 DAY)),

-- Product 3 transactions
('income', NULL, 3, NULL, 125.00, 'Online order #3001', DATE_SUB(CURDATE(), INTERVAL 60 DAY)),
('income', NULL, 3, NULL, 130.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 56 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3002', DATE_SUB(CURDATE(), INTERVAL 53 DAY)),
('income', NULL, 3, NULL, 128.75, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 50 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3003', DATE_SUB(CURDATE(), INTERVAL 47 DAY)),
('income', NULL, 3, NULL, 130.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 44 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3004', DATE_SUB(CURDATE(), INTERVAL 41 DAY)),
('income', NULL, 3, NULL, 128.75, 'Online order #3005', DATE_SUB(CURDATE(), INTERVAL 37 DAY)),
('income', NULL, 3, NULL, 125.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 34 DAY)),
('income', NULL, 3, NULL, 130.50, 'Online order #3006', DATE_SUB(CURDATE(), INTERVAL 31 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3007', DATE_SUB(CURDATE(), INTERVAL 29 DAY)),
('income', NULL, 3, NULL, 125.00, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 26 DAY)),
('income', NULL, 3, NULL, 130.50, 'Online order #3008', DATE_SUB(CURDATE(), INTERVAL 23 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3009', DATE_SUB(CURDATE(), INTERVAL 19 DAY)),
('income', NULL, 3, NULL, 128.75, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 16 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3010', DATE_SUB(CURDATE(), INTERVAL 14 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3011', DATE_SUB(CURDATE(), INTERVAL 11 DAY)),
('income', NULL, 3, NULL, 130.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 9 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3012', DATE_SUB(CURDATE(), INTERVAL 7 DAY)),
('income', NULL, 3, NULL, 125.00, 'Online order #3013', DATE_SUB(CURDATE(), INTERVAL 4 DAY)),

-- Product 5 transactions
('income', NULL, 5, NULL, 75.50, 'Online order #5001', DATE_SUB(CURDATE(), INTERVAL 59 DAY)),
('income', NULL, 5, NULL, 78.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 57 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5002', DATE_SUB(CURDATE(), INTERVAL 54 DAY)),
('income', NULL, 5, NULL, 80.25, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 52 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5003', DATE_SUB(CURDATE(), INTERVAL 49 DAY)),
('income', NULL, 5, NULL, 78.00, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 46 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5004', DATE_SUB(CURDATE(), INTERVAL 44 DAY)),
('income', NULL, 5, NULL, 80.25, 'Online order #5005', DATE_SUB(CURDATE(), INTERVAL 42 DAY)),
('income', NULL, 5, NULL, 75.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 39 DAY)),
('income', NULL, 5, NULL, 78.00, 'Online order #5006', DATE_SUB(CURDATE(), INTERVAL 36 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5007', DATE_SUB(CURDATE(), INTERVAL 33 DAY)),
('income', NULL, 5, NULL, 75.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 31 DAY)),
('income', NULL, 5, NULL, 78.00, 'Online order #5008', DATE_SUB(CURDATE(), INTERVAL 28 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5009', DATE_SUB(CURDATE(), INTERVAL 25 DAY)),
('income', NULL, 5, NULL, 80.25, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 22 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5010', DATE_SUB(CURDATE(), INTERVAL 20 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5011', DATE_SUB(CURDATE(), INTERVAL 17 DAY)),
('income', NULL, 5, NULL, 78.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 14 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5012', DATE_SUB(CURDATE(), INTERVAL 11 DAY)),
('income', NULL, 5, NULL, 75.50, 'Online order #5013', DATE_SUB(CURDATE(), INTERVAL 8 DAY)),

-- Product 7 transactions
('income', NULL, 7, NULL, 199.99, 'Online order #7001', DATE_SUB(CURDATE(), INTERVAL 60 DAY)),
('income', NULL, 7, NULL, 205.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 58 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7002', DATE_SUB(CURDATE(), INTERVAL 55 DAY)),
('income', NULL, 7, NULL, 210.50, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 53 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7003', DATE_SUB(CURDATE(), INTERVAL 51 DAY)),
('income', NULL, 7, NULL, 205.00, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 48 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7004', DATE_SUB(CURDATE(), INTERVAL 45 DAY)),
('income', NULL, 7, NULL, 210.50, 'Online order #7005', DATE_SUB(CURDATE(), INTERVAL 43 DAY)),
('income', NULL, 7, NULL, 199.99, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 40 DAY)),
('income', NULL, 7, NULL, 205.00, 'Online order #7006', DATE_SUB(CURDATE(), INTERVAL 37 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7007', DATE_SUB(CURDATE(), INTERVAL 35 DAY)),
('income', NULL, 7, NULL, 199.99, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 32 DAY)),
('income', NULL, 7, NULL, 205.00, 'Online order #7008', DATE_SUB(CURDATE(), INTERVAL 29 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7009', DATE_SUB(CURDATE(), INTERVAL 26 DAY)),
('income', NULL, 7, NULL, 210.50, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 24 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7010', DATE_SUB(CURDATE(), INTERVAL 21 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7011', DATE_SUB(CURDATE(), INTERVAL 18 DAY)),
('income', NULL, 7, NULL, 205.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 15 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7012', DATE_SUB(CURDATE(), INTERVAL 12 DAY)),
('income', NULL, 7, NULL, 199.99, 'Online order #7013', DATE_SUB(CURDATE(), INTERVAL 9 DAY)),

-- Product 8 transactions
('income', NULL, 8, NULL, 64.99, 'Online order #8001', DATE_SUB(CURDATE(), INTERVAL 60 DAY)),
('income', NULL, 8, NULL, 68.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 58 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8002', DATE_SUB(CURDATE(), INTERVAL 56 DAY)),
('income', NULL, 8, NULL, 67.25, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 53 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8003', DATE_SUB(CURDATE(), INTERVAL 51 DAY)),
('income', NULL, 8, NULL, 68.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 48 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8004', DATE_SUB(CURDATE(), INTERVAL 46 DAY)),
('income', NULL, 8, NULL, 67.25, 'Online order #8005', DATE_SUB(CURDATE(), INTERVAL 44 DAY)),
('income', NULL, 8, NULL, 64.99, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 41 DAY)),
('income', NULL, 8, NULL, 68.50, 'Online order #8006', DATE_SUB(CURDATE(), INTERVAL 38 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8007', DATE_SUB(CURDATE(), INTERVAL 36 DAY)),
('income', NULL, 8, NULL, 64.99, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 33 DAY)),
('income', NULL, 8, NULL, 68.50, 'Online order #8008', DATE_SUB(CURDATE(), INTERVAL 30 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8009', DATE_SUB(CURDATE(), INTERVAL 27 DAY)),
('income', NULL, 8, NULL, 67.25, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 24 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8010', DATE_SUB(CURDATE(), INTERVAL 21 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8011', DATE_SUB(CURDATE(), INTERVAL 18 DAY)),
('income', NULL, 8, NULL, 68.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 15 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8012', DATE_SUB(CURDATE(), INTERVAL 12 DAY)),
('income', NULL, 8, NULL, 64.99, 'Online order #8013', DATE_SUB(CURDATE(), INTERVAL 9 DAY));

-- Example non-product transactions (expenses, other income)
-- These demonstrate how the nullable fields support various transaction types

INSERT INTO transactions (type, category_id, product_id, variant_id, amount, description, date) VALUES
-- Material procurement expenses
('expense', NULL, NULL, NULL, 250.00, 'PLA filament bulk order - 10kg', DATE_SUB(CURDATE(), INTERVAL 45 DAY)),
('expense', NULL, NULL, NULL, 150.00, 'Resin purchase - 5L', DATE_SUB(CURDATE(), INTERVAL 30 DAY)),
('expense', NULL, NULL, NULL, 89.99, 'Paint and finishing supplies', DATE_SUB(CURDATE(), INTERVAL 25 DAY)),

-- Delivery/shipping expenses
('expense', NULL, NULL, NULL, 45.50, 'Shipping for order #1001-1010', DATE_SUB(CURDATE(), INTERVAL 20 DAY)),
('expense', NULL, NULL, NULL, 32.00, 'Shipping for order #2001-2005', DATE_SUB(CURDATE(), INTERVAL 15 DAY)),

-- Other income (not product sales)
('income', NULL, NULL, NULL, 500.00, 'Custom design consultation fee', DATE_SUB(CURDATE(), INTERVAL 10 DAY)),
('income', NULL, NULL, NULL, 200.00, '3D modeling service', DATE_SUB(CURDATE(), INTERVAL 5 DAY));
