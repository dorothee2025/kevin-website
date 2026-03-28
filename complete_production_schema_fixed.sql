-- Corrected Database Schema to Fix TIMESTAMP Default Value Errors

CREATE TABLE example_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add other tables and definitions as needed