-- =====================================================
-- PIC Seed Data - Users (25 Students + 5 Teachers + 1 Admin)
-- =====================================================
-- Passwords are bcrypt hashed versions of "FirstName123"
-- For seeding, we use a common hash for simplicity: password_hash('Password123', PASSWORD_BCRYPT)
-- Hash for "Password123" = $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- Admin account
INSERT IGNORE INTO users (name, email, password, role, class, major, phone, is_active) VALUES
('Admin PIC', 'admin@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NULL, '081200000000', 1);

-- Teachers (5)
INSERT IGNORE INTO users (name, email, password, role, class, major, phone, is_active) VALUES
('Siti Rahmawati', 'siti.rahmawati@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Teacher', NULL, '081234567801', 1),
('Ahmad Fauzan', 'ahmad.fauzan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Teacher', NULL, '081234567802', 1),
('Jonathan Lim', 'jonathan.lim@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Teacher', NULL, '081234567803', 1),
('Maria Susanti', 'maria.susanti@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Teacher', NULL, '081234567804', 1),
('Budi Hartono', 'budi.hartono@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'Teacher', NULL, '081234567805', 1);

-- Students Grade 7-9 (no major) - 8 students
INSERT IGNORE INTO users (name, email, password, role, class, major, phone, is_active) VALUES
('Rina Kartika', 'rina.kartika@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '7-A', NULL, '081345678901', 1),
('Dimas Prasetyo', 'dimas.prasetyo@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '7-B', NULL, '081345678902', 1),
('Anisa Putri', 'anisa.putri@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '8-A', NULL, '081345678903', 1),
('Fajar Nugroho', 'fajar.nugroho@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '8-B', NULL, '081345678904', 1),
('Putri Handayani', 'putri.handayani@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '9-A', NULL, '081345678905', 1),
('Rizky Saputra', 'rizky.saputra@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '9-A', NULL, '081345678906', 1),
('Dewi Lestari', 'dewi.lestari@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '9-B', NULL, '081345678907', 1),
('Bayu Firmansyah', 'bayu.firmansyah@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '9-B', NULL, '081345678908', 1);

-- Students Grade 10 (with major) - 6 students
INSERT IGNORE INTO users (name, email, password, role, class, major, phone, is_active) VALUES
('Brian Smith', 'brian.smith@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '10-C', 'TKJ', '081456789001', 1),
('Maria Gonzalez', 'maria.gonzalez@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '10-D', 'AKL', '081456789002', 1),
('Daniel Park', 'daniel.park@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '10-D', 'BDP', '081456789003', 1),
('Indah Permata', 'indah.permata@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '10-A', 'TKJ', '081456789004', 1),
('Ryan Smith', 'ryan.smith@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '10-B', 'AKL', '081456789005', 1),
('Novi Anggraini', 'novi.anggraini@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '10-A', 'BDP', '081456789006', 1);

-- Students Grade 11 (with major) - 6 students
INSERT IGNORE INTO users (name, email, password, role, class, major, phone, is_active) VALUES
('Michelle Tan', 'michelle.tan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '11-C', 'TKJ', '081567890001', 1),
('Aisha Khan', 'aisha.khan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '11-B', 'AKL', '081567890002', 1),
('Ethan Wong', 'ethan.wong@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '11-C', 'BDP', '081567890003', 1),
('Liam Chen', 'liam.chen@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '11-D', 'TKJ', '081567890004', 1),
('Andi Pratama', 'andi.pratama@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '11-A', 'AKL', '081567890005', 1),
('Citra Dewi', 'citra.dewi@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '11-A', 'BDP', '081567890006', 1);

-- Students Grade 12 (with major) - 5 students
INSERT IGNORE INTO users (name, email, password, role, class, major, phone, is_active) VALUES
('Jonathan Lee', 'jonathan.lee@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '12-D', 'TKJ', '081678900001', 1),
('Kevin Lee', 'kevin.lee@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '12-E', 'AKL', '081678900002', 1),
('Julian Henderson', 'julian.henderson@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '12-E', 'BDP', '081678900003', 1),
('Sarah Wijaya', 'sarah.wijaya@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '12-A', 'TKJ', '081678900004', 1),
('Hendra Gunawan', 'hendra.gunawan@pic.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', '12-A', 'AKL', '081678900005', 1);
