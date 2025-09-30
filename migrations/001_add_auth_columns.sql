-- Migration: add password and role columns to students table
-- Run this against your MySQL database for the app

ALTER TABLE `students`
  ADD COLUMN `password` VARCHAR(255) NULL AFTER `email`,
  ADD COLUMN `role` VARCHAR(32) NOT NULL DEFAULT 'user' AFTER `password`;

-- Optionally, seed default admin (email: admin, password: aldge042224)
-- Use PHP to generate the password hash then run an UPDATE, for example:
-- php -r "echo password_hash('aldge042224', PASSWORD_DEFAULT).PHP_EOL;"
-- Then run:
-- UPDATE `students` SET `password` = 'PASTE_HASH_HERE', `role` = 'admin' WHERE `email` = 'admin';
