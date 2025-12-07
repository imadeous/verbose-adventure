-- Sample transactions for Product 5 with variants (variant IDs 1 and 2)
-- Category: 1
-- Product: 5
-- Variants: 1 and 2

-- Mix of transactions across both variants over the last 60 days
INSERT INTO transactions (type, category_id, product_id, variant_id, amount, description, date) VALUES
-- Variant 1 transactions
('income', 1, 5, 1, 75.50, 'Online order #5001', DATE_SUB(CURDATE(), INTERVAL 60 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5002', DATE_SUB(CURDATE(), INTERVAL 58 DAY)),
('income', 1, 5, 1, 75.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 55 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5003', DATE_SUB(CURDATE(), INTERVAL 52 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5004', DATE_SUB(CURDATE(), INTERVAL 50 DAY)),
('income', 1, 5, 1, 75.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 48 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5005', DATE_SUB(CURDATE(), INTERVAL 45 DAY)),
('income', 1, 5, 1, 75.50, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 42 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5006', DATE_SUB(CURDATE(), INTERVAL 40 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5007', DATE_SUB(CURDATE(), INTERVAL 38 DAY)),
('income', 1, 5, 1, 75.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 35 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5008', DATE_SUB(CURDATE(), INTERVAL 32 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5009', DATE_SUB(CURDATE(), INTERVAL 28 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5010', DATE_SUB(CURDATE(), INTERVAL 25 DAY)),
('income', 1, 5, 1, 75.50, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 22 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5011', DATE_SUB(CURDATE(), INTERVAL 18 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5012', DATE_SUB(CURDATE(), INTERVAL 15 DAY)),
('income', 1, 5, 1, 75.50, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 12 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5013', DATE_SUB(CURDATE(), INTERVAL 8 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5014', DATE_SUB(CURDATE(), INTERVAL 5 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5015', DATE_SUB(CURDATE(), INTERVAL 3 DAY)),
('income', 1, 5, 1, 75.50, 'Online order #5016', DATE_SUB(CURDATE(), INTERVAL 1 DAY)),

-- Variant 2 transactions
('income', 1, 5, 2, 78.00, 'Online order #5101', DATE_SUB(CURDATE(), INTERVAL 59 DAY)),
('income', 1, 5, 2, 78.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 57 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5102', DATE_SUB(CURDATE(), INTERVAL 54 DAY)),
('income', 1, 5, 2, 78.00, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 51 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5103', DATE_SUB(CURDATE(), INTERVAL 49 DAY)),
('income', 1, 5, 2, 78.00, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 46 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5104', DATE_SUB(CURDATE(), INTERVAL 43 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5105', DATE_SUB(CURDATE(), INTERVAL 41 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5106', DATE_SUB(CURDATE(), INTERVAL 39 DAY)),
('income', 1, 5, 2, 78.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 36 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5107', DATE_SUB(CURDATE(), INTERVAL 33 DAY)),
('income', 1, 5, 2, 78.00, 'In-store purchase', DATE_SUB(CURDATE(), INTERVAL 30 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5108', DATE_SUB(CURDATE(), INTERVAL 27 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5109', DATE_SUB(CURDATE(), INTERVAL 24 DAY)),
('income', 1, 5, 2, 78.00, 'Wholesale order', DATE_SUB(CURDATE(), INTERVAL 20 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5110', DATE_SUB(CURDATE(), INTERVAL 17 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5111', DATE_SUB(CURDATE(), INTERVAL 13 DAY)),
('income', 1, 5, 2, 78.00, 'Custom order', DATE_SUB(CURDATE(), INTERVAL 10 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5112', DATE_SUB(CURDATE(), INTERVAL 6 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5113', DATE_SUB(CURDATE(), INTERVAL 4 DAY)),
('income', 1, 5, 2, 78.00, 'Online order #5114', DATE_SUB(CURDATE(), INTERVAL 2 DAY)),
('income', 1, 5, 2, 78.00, 'In-store purchase', CURDATE());

-- Summary: 
-- 22 transactions for variant 1 @ 75.50 each = 1,661.00 total
-- 22 transactions for variant 2 @ 78.00 each = 1,716.00 total
-- Grand total: 44 transactions worth 3,377.00
