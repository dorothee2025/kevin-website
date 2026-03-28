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
