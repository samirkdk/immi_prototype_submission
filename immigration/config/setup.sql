-- Nepal Department of Immigration
-- Database setup script
-- Run this once to create the database and tables

CREATE DATABASE IF NOT EXISTS immigration_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE immigration_db;

CREATE TABLE IF NOT EXISTS visa_applications (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    reference_number  VARCHAR(25) UNIQUE NOT NULL,
    full_name         VARCHAR(150) NOT NULL,
    email             VARCHAR(150) NOT NULL,
    phone             VARCHAR(25) NOT NULL,
    nationality       VARCHAR(100) NOT NULL,
    date_of_birth     DATE NOT NULL,
    passport_number   VARCHAR(50) NOT NULL,
    passport_expiry   DATE NOT NULL,
    visa_type         ENUM('Tourist','Business','Transit','Student','Entry') NOT NULL,
    entry_date        DATE NOT NULL,
    duration_days     INT NOT NULL DEFAULT 30,
    status            ENUM('Submitted','Under Review','Approved','Rejected') NOT NULL DEFAULT 'Submitted',
    admin_notes       TEXT DEFAULT NULL,
    submitted_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    username     VARCHAR(50) UNIQUE NOT NULL,
    password     VARCHAR(255) NOT NULL,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed admin user for local setup only.
-- IMPORTANT: Replace the hash with one generated from your own strong password.

INSERT INTO admin_users (username, password) VALUES
('admin', '$2y$10$REPLACE_WITH_YOUR_GENERATED_HASH')
ON DUPLICATE KEY UPDATE username = username;