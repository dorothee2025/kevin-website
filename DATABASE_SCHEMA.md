# Complete Database Schema for Kevin Website

This document contains the complete SQL schema for all databases used in the Kevin Website (CS DREAM). The schema includes the main tables and additional migration tables for user state management, admin authentication, and notifications.

## Database Overview

The website uses MySQL with the following main components:
- **User Management**: Authentication, profiles, and preferences
- **Content Management**: News articles and videos
- **Social Features**: Comments and likes
- **Admin System**: Admin authentication and notifications
- **State Management**: User preferences and feature flags

## Main Database Schema

Run this SQL to create the core database structure:

```sql
-- Database schema for kevin-website
-- Run this SQL to create the required tables

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'creator', 'admin') DEFAULT 'user',
    profile_image VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE news (
    news_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT NOT NULL,
    category VARCHAR(50),
    tags JSON,
    is_published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE videos (
    video_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_url VARCHAR(500) NOT NULL,
    thumbnail_url VARCHAR(500),
    category VARCHAR(50),
    tags JSON,
    uploader_id INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (uploader_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    content_type ENUM('news', 'video') NOT NULL,
    content_id INT NOT NULL,
    parent_comment_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (parent_comment_id) REFERENCES comments(comment_id) ON DELETE CASCADE
);

CREATE TABLE likes (
    like_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content_type ENUM('news', 'video') NOT NULL,
    content_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_like (user_id, content_type, content_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Indexes for better performance
CREATE INDEX idx_news_author ON news(author_id);
CREATE INDEX idx_news_category ON news(category);
CREATE INDEX idx_videos_uploader ON videos(uploader_id);
CREATE INDEX idx_videos_category ON videos(category);
CREATE INDEX idx_comments_content ON comments(content_type, content_id);
CREATE INDEX idx_likes_content ON likes(content_type, content_id);
```

## Migration Tables (Additional Features)

Run these SQL statements after the main schema to add advanced features:

```sql
-- Add user state table for tracking intro, preferences, and feature flags
CREATE TABLE IF NOT EXISTS user_state (
    user_state_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    intro_seen BOOLEAN DEFAULT FALSE,
    history_hint_dismissed BOOLEAN DEFAULT FALSE,
    preferences JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user (user_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_intro_seen (intro_seen)
);

-- Add admin sessions table for admin authentication
CREATE TABLE IF NOT EXISTS admin_sessions (
    admin_session_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    session_token VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_session_token (session_token),
    INDEX idx_expires_at (expires_at)
);

-- Add notification log table
CREATE TABLE IF NOT EXISTS notification_log (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('video', 'news') NOT NULL,
    content_id INT NOT NULL,
    title VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_content (content_type, content_id),
    INDEX idx_created_at (created_at)
);

-- Add notification seen tracking
CREATE TABLE IF NOT EXISTS notification_seen (
    notification_seen_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    notification_id INT NOT NULL,
    seen_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_admin_notification (admin_id, notification_id),
    FOREIGN KEY (admin_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (notification_id) REFERENCES notification_log(notification_id) ON DELETE CASCADE
);
```

## Table Descriptions

### 1. users
- **Purpose**: Stores user account information
- **Key Fields**:
  - `user_id`: Primary key
  - `username`: Unique username (50 chars)
  - `email`: Unique email address (100 chars)
  - `password_hash`: Bcrypt hashed password
  - `role`: User role (user/creator/admin)
  - `profile_image`: Profile picture URL
  - `is_active`: Account status

### 2. news
- **Purpose**: News articles and blog posts
- **Key Fields**:
  - `news_id`: Primary key
  - `title`: Article title
  - `content`: Full article content
  - `author_id`: Foreign key to users
  - `category`: News category
  - `tags`: JSON array of tags
  - `is_published`: Publication status

### 3. videos
- **Purpose**: Video content storage
- **Key Fields**:
  - `video_id`: Primary key
  - `title`: Video title
  - `description`: Video description
  - `video_url`: Video file/stream URL
  - `thumbnail_url`: Thumbnail image URL
  - `category`: Video category
  - `tags`: JSON array of tags
  - `uploader_id`: Foreign key to users
  - `is_active`: Video status

### 4. comments
- **Purpose**: Comments on news and videos
- **Key Fields**:
  - `comment_id`: Primary key
  - `content`: Comment text
  - `user_id`: Comment author
  - `content_type`: 'news' or 'video'
  - `content_id`: ID of content being commented on
  - `parent_comment_id`: For nested replies

### 5. likes
- **Purpose**: Like/dislike tracking
- **Key Fields**:
  - `like_id`: Primary key
  - `user_id`: User who liked
  - `content_type`: 'news' or 'video'
  - `content_id`: ID of liked content
  - `unique_like`: Prevents duplicate likes

### 6. user_state
- **Purpose**: User preferences and feature flags
- **Key Fields**:
  - `user_state_id`: Primary key
  - `user_id`: Foreign key to users
  - `intro_seen`: Has user seen intro?
  - `history_hint_dismissed`: Has hint been dismissed?
  - `preferences`: JSON object of user preferences

### 7. admin_sessions
- **Purpose**: Admin authentication sessions
- **Key Fields**:
  - `admin_session_id`: Primary key
  - `user_id`: Optional admin user ID
  - `session_token`: Unique session identifier
  - `ip_address`: IP address of login
  - `user_agent`: Browser user agent
  - `expires_at`: Session expiration time
  - `is_active`: Session status

### 8. notification_log
- **Purpose**: System notifications for admins
- **Key Fields**:
  - `notification_id`: Primary key
  - `content_type`: 'video' or 'news'
  - `content_id`: ID of new content
  - `title`: Notification title

### 9. notification_seen
- **Purpose**: Track which notifications admins have seen
- **Key Fields**:
  - `notification_seen_id`: Primary key
  - `admin_id`: Admin user ID
  - `notification_id`: Foreign key to notification_log
  - `seen_at`: When notification was viewed

## Installation Instructions

1. **Create Database**:
   ```sql
   CREATE DATABASE kevin_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   USE kevin_website;
   ```

2. **Run Main Schema**:
   - Execute the main database schema SQL above
   - This creates the core tables: users, news, videos, comments, likes

3. **Run Migration Tables**:
   - Execute the migration SQL above
   - This adds advanced features: user_state, admin_sessions, notifications

4. **Create Admin User** (Optional):
   ```sql
   -- Insert an admin user (password should be hashed)
   INSERT INTO users (username, email, password_hash, role) 
   VALUES ('admin', 'admin@kevinsite.com', '$2y$10$hashedpassword', 'admin');
   ```

## Database Configuration

In your PHP config file (`api/config.php`), ensure the database connection is set up:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'kevin_website');
?>
```

## Indexes and Performance

The schema includes optimized indexes for common queries:
- User lookups by username/email
- Content filtering by category/author
- Comment and like queries by content
- Session token lookups
- Notification filtering

## Data Types and Constraints

- **Primary Keys**: All tables use AUTO_INCREMENT INT
- **Foreign Keys**: CASCADE delete to maintain referential integrity
- **Unique Constraints**: Prevent duplicate usernames, emails, and likes
- **JSON Fields**: For flexible tag and preference storage
- **Timestamps**: Automatic creation and update tracking
- **Enums**: Restricted values for roles, content types, etc.

## Backup Recommendations

Regular backups should include:
1. Full database dump
2. User uploaded files (profile images, video thumbnails)
3. Video files (if stored locally)

Example backup command:
```bash
mysqldump -u username -p kevin_website > backup_$(date +%Y%m%d).sql
```

## Migration Notes

- All migration tables use `IF NOT EXISTS` to prevent errors on re-run
- Foreign key constraints ensure data integrity
- Indexes improve query performance
- JSON fields allow flexible data storage without schema changes

This schema supports the full functionality of the CS DREAM website including user authentication, content management, social features, admin dashboard, and user preferences.