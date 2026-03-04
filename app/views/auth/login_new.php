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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pontianak International College</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Kameron:wght@400;700&family=Kanit:wght@400;600&family=Crimson+Pro:wght@400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        /* Login Page Specific Styles */
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #043460 0%, #0A4A80 100%);
            padding: 20px;
        }

        .auth-container {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }

        .auth-header {
            background: var(--primary-navy);
            padding: 40px 40px 30px;
            text-align: center;
        }

        .auth-logo {
            display: inline-block;
            margin-bottom: 15px;
        }

        .auth-logo-main {
            font-family: 'Kameron', serif;
            font-size: 36px;
            font-weight: bold;
            color: var(--white);
        }

        .auth-logo-sub {
            display: block;
            font-size: 14px;
            color: var(--gold);
            letter-spacing: 2px;
        }

        .auth-title {
            font-family: 'Kanit', sans-serif;
            font-size: 24px;
            color: var(--white);
            margin: 0;
        }

        .auth-subtitle {
            font-family: 'Crimson Pro', serif;
            color: rgba(255,255,255,0.7);
            margin-top: 8px;
            font-size: 16px;
        }

        .auth-body {
            padding: 40px;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-family: 'Crimson Pro', serif;
            font-size: 15px;
        }

        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            color: #DC2626;
        }

        .alert-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #16A34A;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-family: 'Kanit', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--dark-text);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid var(--border-soft);
            border-radius: 8px;
            font-family: 'Crimson Pro', serif;
            font-size: 16px;
            color: var(--dark-text);
            transition: all 0.3s ease;
            background: var(--light-bg);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-navy);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(4,52,96,0.1);
        }

        .form-input::placeholder {
            color: var(--light-text);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .form-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-navy);
        }

        .form-checkbox label {
            font-family: 'Crimson Pro', serif;
            color: var(--dark-text);
            cursor: pointer;
        }

        .btn-auth {
            width: 100%;
            padding: 16px;
            background: var(--gold);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-family: 'Kanit', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-auth:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(202,159,55,0.4);
        }

        .auth-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--border-soft);
            margin-top: 24px;
        }

        .auth-footer p {
            font-family: 'Crimson Pro', serif;
            color: var(--light-text);
            margin: 0;
        }

        .auth-footer a {
            color: var(--primary-navy);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: var(--gold);
        }

        .forgot-link {
            display: block;
            text-align: right;
            margin-top: -12px;
            margin-bottom: 20px;
        }

        .forgot-link a {
            font-family: 'Crimson Pro', serif;
            font-size: 14px;
            color: var(--light-text);
            text-decoration: none;
        }

        .forgot-link a:hover {
            color: var(--primary-navy);
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            font-family: 'Kanit', sans-serif;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .back-home a:hover {
            color: var(--white);
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-container {
            animation: fadeInUp 0.5s ease;
        }
    </style>
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">
                <span class="auth-logo-main">PIC</span>
                <span class="auth-logo-sub">SOCIAL ACTIVITY</span>
            </div>
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Login to your account</p>
        </div>
        
        <div class="auth-body">
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
            
            <form action="/auth/authenticate" method="POST" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Enter your email"
                        required
                        autocomplete="email"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                </div>
                
                <div class="forgot-link">
                    <a href="/auth/forgot-password">Forgot Password?</a>
                </div>
                
                <div class="form-checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                
                <button type="submit" class="btn-auth">Login</button>
            </form>
            
            <div class="auth-footer">
                <p>Don't have an account? <a href="/auth/register">Register here</a></p>
            </div>
        </div>
    </div>
    
    <div class="back-home">
        <a href="/">← Back to Home</a>
    </div>
    
    <script>
        // Client-side validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            if (!email) {
                alert('Please enter your email address.');
                e.preventDefault();
                return;
            }
            
            if (!password) {
                alert('Please enter your password.');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>
