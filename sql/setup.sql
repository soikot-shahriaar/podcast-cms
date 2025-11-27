-- Podcast Episode Manager CMS Database Setup
-- Run this script to create the required database and tables

CREATE DATABASE IF NOT EXISTS podcast_cms;
USE podcast_cms;

-- Users table for authentication
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Episodes table for podcast episode management
CREATE TABLE IF NOT EXISTS episodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    audio_file VARCHAR(255),
    duration VARCHAR(20),
    release_date DATE,
    status ENUM('draft', 'published') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_episodes_user_id ON episodes(user_id);
CREATE INDEX idx_episodes_status ON episodes(status);
CREATE INDEX idx_episodes_release_date ON episodes(release_date);
CREATE INDEX idx_episodes_title ON episodes(title);

-- Insert sample admin user (password: admin123)
INSERT INTO users (username, email, password_hash, first_name, last_name) VALUES 
('admin', 'admin@example.com', '$2y$10$8K1p/a0dL1LXMIgoEDFrwOe6xKxqKxqKxqKxqKxqKxqKxqKxqK', 'Admin', 'User');

-- Insert sample episodes
INSERT INTO episodes (user_id, title, description, duration, release_date, status) VALUES 
(1, 'Welcome to Our Podcast', 'This is our first episode where we introduce ourselves and talk about what to expect from our podcast.', '25:30', '2024-01-15', 'published'),
(1, 'Episode 2: Getting Started', 'In this episode, we dive deeper into our main topics and share some insights.', '32:45', '2024-01-22', 'published'),
(1, 'Episode 3: Advanced Topics', 'We explore more advanced concepts and answer listener questions.', '28:15', '2024-01-29', 'draft');

