<?php
// Check if user is already logged in, redirect to dashboard
if (\App\Core\Session::isLoggedIn()) {
    $role = \App\Core\Session::getUserRole();
    $redirects = [
        'admin' => '/admin/dashboard',
        'committee' => '/committee/dashboard',
        'student' => '/student/dashboard',
        'teacher' => '/teacher/dashboard'
    ];
    $redirect = $redirects[$role] ?? '/dashboard';
    header('Location: ' . $redirect);
    exit;
}

// Get flash messages
$error = \App\Core\Session::getFlash('error');
$success = \App\Core\Session::getFlash('success');

// Determine which form to show (login or register)
$showRegister = $_GET['mode'] ?? 'login';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $showRegister === 'register' ? 'Register' : 'Login' ?> - Pontianak International College</title>
    
    <!-- Google Fonts - Landing Page Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400;700&family=Kanit:wght@400;600&family=Crimson+Pro:wght@400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-navy: #043460;
            --navy-hover: #0A4A80;
            --gold: #CA9F37;
            --gold-hover: #D8B25A;
            --text-dark: #1E293B;
            --text-light: #64748B;
            --white: #ffffff;
            --bg-light: #F5F7FA;
            --success: #38a169;
            --error: #e53e3e;
            --border-soft: #E2E8F0;
        }

        body {
            font-family: 'Crimson Pro', serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            /* School Background Image - Local */
            background: linear-gradient(rgba(4,52,96,0.85), rgba(4,52,96,0.75)),
                        url('/assets/images/school_view.png') center/cover no-repeat;
        }

        /* Main Container - Landscape Box */
        .auth-container {
            width: 100%;
            max-width: 850px;
            min-height: 480px;
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            display: flex;
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Side - Branding */
        .auth-brand {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--navy-hover) 100%);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: shimmer 3s infinite linear;
        }

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .brand-logo-img {
            max-width: 200px;
            width: 100%;
            height: auto;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .brand-tagline {
            color: var(--gold);
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .brand-title {
            color: var(--white);
            font-family: 'Kameron', serif;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .brand-description {
            color: rgba(255,255,255,0.8);
            font-family: 'Crimson Pro', serif;
            font-size: 15px;
            line-height: 1.7;
            max-width: 280px;
            position: relative;
            z-index: 1;
        }

        /* Toggle Buttons */
        .brand-toggle {
            margin-top: 40px;
            display: flex;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .toggle-btn {
            padding: 12px 28px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 30px;
            background: transparent;
            color: var(--white);
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .toggle-btn.active {
            background: var(--gold);
            border-color: var(--gold);
        }

        .toggle-btn:hover:not(.active) {
            border-color: var(--white);
            background: rgba(255,255,255,0.1);
        }

        /* Right Side - Form */
        .auth-form-side {
            flex: 1;
            padding: 30px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--white);
            overflow-y: auto;
        }

        .form-header {
            margin-bottom: 20px;
        }

        .form-title {
            font-family: 'Kanit', sans-serif;
            font-size: 28px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-family: 'Crimson Pro', serif;
            font-size: 14px;
            color: var(--text-light);
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-family: 'Crimson Pro', serif;
            font-size: 14px;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-error {
            background: #FEE2E2;
            border: 1px solid #FECACA;
            color: var(--error);
        }

        .alert-success {
            background: #D1FAE5;
            border: 1px solid #A7F3D0;
            color: var(--success);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 12px;
        }

        .form-label {
            display: block;
            font-family: 'Kanit', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid var(--border-soft);
            border-radius: 8px;
            font-family: 'Crimson Pro', serif;
            font-size: 13px;
            color: var(--text-dark);
            transition: all 0.3s ease;
            background: var(--bg-light);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-navy);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(4,52,96,0.1);
        }

        .form-input::placeholder {
            color: #A0AEC0;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--navy-hover) 100%);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(4,52,96,0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid var(--border-soft);
        }

        .form-footer p {
            font-family: 'Crimson Pro', serif;
            font-size: 14px;
            color: var(--text-light);
        }

        .form-footer a {
            color: var(--primary-navy);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: var(--gold);
        }

        /* Remember Me */
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .form-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-navy);
            cursor: pointer;
        }

        .form-checkbox label {
            font-family: 'Crimson Pro', serif;
            font-size: 14px;
            color: var(--text-light);
            cursor: pointer;
        }

        /* Hidden Sections */
        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: var(--white);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                max-width: 450px;
                min-height: auto;
            }

            .auth-brand {
                padding: 35px 25px;
            }

            .brand-logo-img {
                max-width: 160px;
            }

            .brand-title {
                font-size: 20px;
            }

            .auth-form-side {
                padding: 35px 25px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left Side - Branding -->
        <div class="auth-brand">
            <!-- Logo Image -->
            <img src="/assets/images/logo.png" alt="PIC Logo" class="brand-logo-img">
            
            <div class="brand-tagline">Social Activity</div>
            <h2 class="brand-title">Pontianak International College</h2>
            <p class="brand-description">Join our community of volunteers and make a difference in society through social activities and meaningful contributions.</p>
            
            <div class="brand-toggle">
                <button class="toggle-btn <?= $showRegister === 'login' ? 'active' : '' ?>" onclick="switchMode('login')">Login</button>
                <button class="toggle-btn <?= $showRegister === 'register' ? 'active' : '' ?>" onclick="switchMode('register')">Register</button>
            </div>
            
            <div class="back-link">
                <a href="/">← Back to Home</a>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="auth-form-side">
            <!-- Error Alert -->
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <!-- Success Alert -->
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <!-- LOGIN FORM -->
            <div class="form-section <?= $showRegister === 'login' ? 'active' : '' ?>" id="loginSection">
                <div class="form-header">
                    <h1 class="form-title">Welcome Back</h1>
                    <p class="form-subtitle">Login to continue to your dashboard</p>
                </div>
                
                <form action="/auth/authenticate" method="POST" id="loginForm">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    
                    <div class="form-group">
                        <label for="login-email" class="form-label">Email Address</label>
                        <input type="email" id="login-email" name="email" class="form-input" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="login-password" class="form-label">Password</label>
                        <input type="password" id="login-password" name="password" class="form-input" placeholder="Enter your password" required>
                    </div>
                    
                    <div class="form-checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    <button type="submit" class="btn-submit">Login</button>
                </form>
                
                <div class="form-footer">
                    <p>Don't have an account? <a href="/auth/auth?mode=register">Register here</a></p>
                </div>
            </div>

            <!-- REGISTER FORM -->
            <div class="form-section <?= $showRegister === 'register' ? 'active' : '' ?>" id="registerSection">
                <div class="form-header">
                    <h1 class="form-title">Create Account</h1>
                    <p class="form-subtitle">Join us as a volunteer</p>
                </div>
                
                <form action="/auth/store" method="POST" id="registerForm">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                    
                    <div class="form-group">
                        <label for="reg-name" class="form-label">Full Name</label>
                        <input type="text" id="reg-name" name="name" class="form-input" placeholder="Enter your full name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="reg-email" class="form-label">Email Address</label>
                        <input type="email" id="reg-email" name="email" class="form-input" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="reg-nis" class="form-label">NIS (Optional)</label>
                            <input type="text" id="reg-nis" name="nis" class="form-input" placeholder="NIS Number">
                        </div>
                        
                        <div class="form-group">
                            <label for="reg-class" class="form-label">Class</label>
                            <input type="text" id="reg-class" name="class" class="form-input" placeholder="XI IPA 1">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reg-phone" class="form-label">Phone (Optional)</label>
                        <input type="tel" id="reg-phone" name="phone" class="form-input" placeholder="Phone number">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="reg-password" class="form-label">Password</label>
                            <input type="password" id="reg-password" name="password" class="form-input" placeholder="Min 6 characters" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="reg-confirm" class="form-label">Confirm Password</label>
                            <input type="password" id="reg-confirm" name="confirm_password" class="form-input" placeholder="Repeat password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">Register</button>
                </form>
                
                <div class="form-footer">
                    <p>Already have an account? <a href="/auth/auth?mode=login">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function switchMode(mode) {
            // Update toggle buttons
            document.querySelectorAll('.toggle-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            // Show/hide form sections
            document.getElementById('loginSection').classList.remove('active');
            document.getElementById('registerSection').classList.remove('active');
            
            if (mode === 'login') {
                document.getElementById('loginSection').classList.add('active');
            } else {
                document.getElementById('registerSection').classList.add('active');
            }
            
            // Update URL without reload
            const url = new URL(window.location);
            url.searchParams.set('mode', mode);
            window.history.pushState({}, '', url);
        }
        
        // Client-side validation for login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
        
        // Client-side validation for register
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('reg-password').value;
            const confirmPassword = document.getElementById('reg-confirm').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password and confirm password do not match!');
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters!');
            }
        });
    </script>
</body>
</html>

