-- =====================================================
-- PIC Events & News System - Database Migration
-- =====================================================

-- Update users table to add major field (safe - ignore if exists)
SET @s = (SELECT IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'major') > 0,
    'SELECT 1',
    'ALTER TABLE users ADD COLUMN major VARCHAR(10) DEFAULT NULL AFTER `class`'
));
PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Create events table
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image_url VARCHAR(500) DEFAULT NULL,
    date DATE NOT NULL,
    description TEXT,
    target_donation DECIMAL(15,2) DEFAULT NULL,
    created_by INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_events_date (date),
    INDEX idx_events_created_by (created_by)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create participants table
CREATE TABLE IF NOT EXISTS participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_participant (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_participants_event (event_id),
    INDEX idx_participants_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create event_donations table (separate from existing donations)
CREATE TABLE IF NOT EXISTS event_donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    user_id INT DEFAULT NULL,
    donor_name VARCHAR(255) NOT NULL,
    donor_class VARCHAR(50) DEFAULT NULL,
    amount DECIMAL(15,2) NOT NULL,
    message TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_edonations_event (event_id),
    INDEX idx_edonations_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create news table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image_url VARCHAR(500) DEFAULT NULL,
    date DATE NOT NULL,
    description TEXT,
    category VARCHAR(50) DEFAULT 'General',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_news_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create role_audit_log table
CREATE TABLE IF NOT EXISTS role_audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    changed_by INT NOT NULL,
    old_role VARCHAR(20) NOT NULL,
    new_role VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (changed_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
