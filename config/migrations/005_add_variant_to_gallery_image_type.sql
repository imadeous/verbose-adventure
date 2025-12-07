-- Migration: Add 'variant' to gallery.image_type ENUM
-- This allows gallery images to be associated with product variants

ALTER TABLE gallery 
MODIFY COLUMN image_type ENUM('site','category','product','variant') NOT NULL;
