-- =====================================================
-- PIC Social Activity & Volunteer Management System
-- Database Schema for Pontianak International College
-- =====================================================

-- Drop database if exists (for fresh install)
DROP DATABASE IF EXISTS pic_volunteer_system;
CREATE DATABASE pic_volunteer_system;
USE pic_volunteer_system;

-- =====================================================
-- USERS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'committee', 'student', 'teacher') DEFAULT 'student',
    nis VARCHAR(20) UNIQUE,
    class VARCHAR(20),
    phone VARCHAR(20),
    avatar VARCHAR(255) DEFAULT 'default.png',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ACTIVITIES TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS activities (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    activity_date DATE NOT NULL,
    activity_time TIME NOT NULL,
    location VARCHAR(200) NOT NULL,
    max_volunteers INT DEFAULT 0,
    current_volunteers INT DEFAULT 0,
    status ENUM('draft', 'upcoming', 'ongoing', 'completed', 'cancelled') DEFAULT 'draft',
    cover_image VARCHAR(255),
    requirements TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- VOLUNTEERS TABLE (Pendaftaran Relawan)
-- =====================================================
CREATE TABLE IF NOT EXISTS volunteers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    activity_id INT NOT NULL,
    status ENUM('registered', 'confirmed', 'attended', 'completed', 'cancelled', 'rejected') DEFAULT 'registered',
    notes TEXT,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    UNIQUE KEY unique_volunteer (user_id, activity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DONATIONS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS donations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    activity_id INT,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_proof VARCHAR(255),
    donor_name VARCHAR(100),
    message TEXT,
    status ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    donated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SUGGESTIONS TABLE
-- =====================================================
CREATE TABLE IF NOT EXISTS suggestions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('activity', 'improvement', 'event', 'other') DEFAULT 'other',
    status ENUM('pending', 'reviewed', 'approved', 'implemented', 'rejected') DEFAULT 'pending',
    admin_response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ACTIVITY_DOCUMENTS TABLE (Dokumentasi Panitia)
-- =====================================================
CREATE TABLE IF NOT EXISTS activity_documents (
    id INT PRIMARY KEY AUTO_INCREMENT,
    activity_id INT NOT NULL,
    uploaded_by INT NOT NULL,
    title VARCHAR(200),
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50),
    description TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ACTIVITY_ATTENDANCE TABLE (Absensi Kegiatan)
-- =====================================================
CREATE TABLE IF NOT EXISTS activity_attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    volunteer_id INT NOT NULL,
    activity_id INT NOT NULL,
    check_in_time TIMESTAMP NULL,
    check_out_time TIMESTAMP NULL,
    attendance_status ENUM('absent', 'present', 'late', 'excused') DEFAULT 'absent',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (volunteer_id) REFERENCES volunteers(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- SESSIONS TABLE (Untuk remember me)
-- =====================================================
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERT DEFAULT ADMIN (Password: admin123)
-- =====================================================
INSERT INTO users (name, email, password, role, nis, class) 
VALUES (
    'Administrator', 
    'admin@pic.edu', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin', 
    'ADMIN001', 
    'Staff'
);

-- =====================================================
-- INSERT SAMPLE COMMITTEE (Password: committee123)
-- =====================================================
INSERT INTO users (name, email, password, role, nis, class) 
VALUES (
    'Panitia OSIS', 
    'osis@pic.edu', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'committee', 
    'COMMITTEE001', 
    'OSIS'
);

-- =====================================================
-- INSERT SAMPLE STUDENT (Password: student123)
-- =====================================================
INSERT INTO users (name, email, password, role, nis, class) 
VALUES (
    'Siswa Contoh', 
    'student@pic.edu', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'student', 
    '12345', 
    'XI IPA 1'
);

-- =====================================================
-- INSERT SAMPLE ACTIVITIES
-- =====================================================
INSERT INTO activities (title, description, activity_date, activity_time, location, max_volunteers, current_volunteers, status, requirements, created_by) 
VALUES 
('Bakti Sosial Lingkungan', 'Membersihkan lingkungan sekolah dan sekitar', '2026-02-15', '07:00:00', 'Area Sekolah', 50, 0, 'upcoming', 'Membawa sapu dan masker', 1),
('Penggalangan Dana Bencana', 'Mengumpulkan dana untuk korban bencana', '2026-02-20', '08:00:00', 'Lobby Utama', 30, 0, 'upcoming', 'Membawa kotak infak', 1),
('kerja Bakti Masjid', 'Membersihkan area masjid sekolah', '2026-02-25', '13:00:00', 'Masjid PIC', 25, 0, 'upcoming', 'Tidak ada persyaratan khusus', 1);

-- =====================================================
-- INSERT SAMPLE VOLUNTEERS
-- =====================================================
INSERT INTO volunteers (user_id, activity_id, status) VALUES 
(3, 1, 'registered'),
(3, 2, 'confirmed');

-- =====================================================
-- INSERT SAMPLE DONATIONS
-- =====================================================
INSERT INTO donations (user_id, activity_id, amount, payment_method, donor_name, status) VALUES 
(3, 2, 50000, 'cash', 'Siswa Contoh', 'verified'),
(NULL, 2, 100000, 'transfer', 'Orang Tua Siswa A', 'pending');

-- =====================================================
-- INSERT SAMPLE SUGGESTIONS
-- =====================================================
INSERT INTO suggestions (user_id, title, description, category, status) VALUES 
(3, 'Tambahkan kegiatan lingkungan', 'Saya ingin ada lebih banyak kegiatan peduli lingkungan seperti menanam pohon', 'activity', 'pending'),
(3, 'Sistem notifikasi', 'Mohon добавить notifikasi agar tahu jika diterima sebagai relawan', 'improvement', 'reviewed');

-- =====================================================
-- INDEXES FOR PERFORMANCE
-- =====================================================
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_activities_status ON activities(status);
CREATE INDEX idx_activities_date ON activities(activity_date);
CREATE INDEX idx_volunteers_user ON volunteers(user_id);
CREATE INDEX idx_volunteers_activity ON volunteers(activity_id);
CREATE INDEX idx_donations_activity ON donations(activity_id);
CREATE INDEX idx_suggestions_user ON suggestions(user_id);

-- =====================================================
-- VIEW: Volunteer History (Riwayat Relawan)
-- =====================================================
CREATE OR REPLACE VIEW volunteer_history AS
SELECT 
    u.id as user_id,
    u.name as student_name,
    u.nis,
    u.class,
    a.id as activity_id,
    a.title as activity_title,
    a.activity_date,
    a.location,
    v.status as volunteer_status,
    v.registered_at
FROM volunteers v
JOIN users u ON v.user_id = u.id
JOIN activities a ON v.activity_id = a.id
ORDER BY a.activity_date DESC;

-- =====================================================
-- VIEW: Activity Statistics
-- =====================================================
CREATE OR REPLACE VIEW activity_stats AS
SELECT 
    a.id,
    a.title,
    a.activity_date,
    a.max_volunteers,
    a.current_volunteers,
    COUNT(DISTINCT v.id) as total_registrations,
    COUNT(DISTINCT CASE WHEN v.status = 'completed' THEN v.id END) as completed_count,
    COALESCE(SUM(d.amount), 0) as total_donations
FROM activities a
LEFT JOIN volunteers v ON a.id = v.activity_id
LEFT JOIN donations d ON a.id = d.activity_id AND d.status = 'verified'
GROUP BY a.id;

-- =====================================================
-- VIEW: User Participation Summary
-- =====================================================
CREATE OR REPLACE VIEW user_participation AS
SELECT 
    u.id as user_id,
    u.name,
    u.nis,
    u.class,
    COUNT(DISTINCT v.id) as total_activities,
    COUNT(DISTINCT CASE WHEN v.status = 'completed' THEN v.id END) as completed_activities,
    COALESCE(SUM(d.amount), 0) as total_donations
FROM users u
LEFT JOIN volunteers v ON u.id = v.user_id
LEFT JOIN donations d ON u.id = d.user_id AND d.status = 'verified'
WHERE u.role IN ('student', 'teacher')
GROUP BY u.id;
