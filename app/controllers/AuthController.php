<?php
/**
 * Auth Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show login form
     */
    public function login(): void
    {
        // If already logged in, redirect to dashboard
        if (Session::isLoggedIn()) {
            $this->redirectTo('/dashboard');
        }

        $this->data['title'] = 'Login - PIC Social Activity';
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('auth/login');
    }

    /**
     * Process login
     */
    public function authenticate(): void
    {
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token. Please try again.');
            $this->redirectTo('/auth/login');
            return;
        }

        // Validate input
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        if (empty($password)) {
            $errors[] = 'Password is required.';
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/auth/login');
            return;
        }

        // Attempt login
        $user = $this->userModel->verifyCredentials($email, $password);

        if ($user === null) {
            Session::setFlash('error', 'Invalid email or password.');
            $this->redirectTo('/auth/login');
            return;
        }

        // Login successful
        Session::login($user);
        
        // Set remember me cookie if checked
        if (isset($_POST['remember']) && $_POST['remember'] === 'on') {
            $this->setRememberMe($user['id']);
        }

        Session::setFlash('success', 'Welcome back, ' . $user['name'] . '!');

        // Redirect based on role
        $this->redirectBasedOnRole($user['role']);
    }

    /**
     * Process logout
     */
    public function logout(): void
    {
        // Clear remember me cookie
        $this->clearRememberMe();

        // Destroy session
        Session::logout();

        Session::setFlash('success', 'You have been logged out successfully.');
        $this->redirectTo('/');
    }

    /**
     * Show registration form
     */
    public function register(): void
    {
        // If already logged in, redirect to dashboard
        if (Session::isLoggedIn()) {
            $this->redirectTo('/dashboard');
        }

        $this->data['title'] = 'Register - PIC Social Activity';
        $this->data['csrf_token'] = Session::getCsrfToken();
        $this->data['roles'] = User::getRoles();

        $this->render('auth/register');
    }

    /**
     * Process registration
     */
    public function store(): void
    {
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token. Please try again.');
            $this->redirectTo('/auth/register');
            return;
        }

        // Validate input
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $nis = trim($_POST['nis'] ?? '');
        $class = trim($_POST['class'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'student';

        $errors = [];

        // Name validation
        if (empty($name)) {
            $errors[] = 'Name is required.';
        } elseif (strlen($name) < 3) {
            $errors[] = 'Name must be at least 3 characters.';
        }

        // Email validation
        if (empty($email)) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        } elseif ($this->userModel->emailExists($email)) {
            $errors[] = 'Email already registered.';
        }

        // Password validation
        if (empty($password)) {
            $errors[] = 'Password is required.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        // Confirm password
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }

        // NIS validation (optional for some roles)
        if (!empty($nis) && $this->userModel->nisExists($nis)) {
            $errors[] = 'NIS already registered.';
        }

        // Role validation
        $allowedRoles = ['student', 'teacher', 'committee'];
        if (!in_array($role, $allowedRoles)) {
            $role = 'student'; // Default role
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/auth/register');
            return;
        }

        // Create user
        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => User::hashPassword($password),
            'role' => $role,
            'nis' => $nis ?: null,
            'class' => $class ?: null,
            'phone' => $phone ?: null,
            'avatar' => 'default.png',
            'is_active' => 1
        ];

        try {
            $userId = $this->userModel->create($userData);

            if ($userId > 0) {
                Session::setFlash('success', 'Registration successful! Please login.');
                $this->redirectTo('/auth/login');
            } else {
                Session::setFlash('error', 'Registration failed. Please try again.');
                $this->redirectTo('/auth/register');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'An error occurred: ' . $e->getMessage());
            $this->redirectTo('/auth/register');
        }
    }

    /**
     * Show forgot password form
     */
    public function forgotPassword(): void
    {
        $this->data['title'] = 'Forgot Password - PIC Social Activity';
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('auth/forgot_password');
    }

    /**
     * Process forgot password request
     */
    public function sendResetLink(): void
    {
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/auth/forgot-password');
            return;
        }

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            Session::setFlash('error', 'Email is required.');
            $this->redirectTo('/auth/forgot-password');
            return;
        }

        // Check if email exists
        $user = $this->userModel->getByEmail($email);

        if ($user) {
            // In production, send email with reset link
            // For now, just show success message
            Session::setFlash('success', 'If this email exists, a reset link has been sent.');
        } else {
            // Don't reveal if email exists or not
            Session::setFlash('success', 'If this email exists, a reset link has been sent.');
        }

        $this->redirectTo('/auth/forgot-password');
    }

    /**
     * Show reset password form
     */
    public function resetPassword(string $token): void
    {
        // In production, validate token from database
        $this->data['title'] = 'Reset Password - PIC Social Activity';
        $this->data['csrf_token'] = Session::getCsrfToken();
        $this->data['token'] = $token;

        $this->render('auth/reset_password');
    }

    /**
     * Process reset password
     */
    public function updatePassword(): void
    {
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/auth/forgot-password');
            return;
        }

        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $token = $_POST['token'] ?? '';

        $errors = [];

        if (empty($password)) {
            $errors[] = 'New password is required.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/auth/reset-password/' . $token);
            return;
        }

        // In production, validate token and get user ID
        // For now, show success
        Session::setFlash('success', 'Password has been reset successfully.');
        $this->redirectTo('/auth/login');
    }

    /**
     * Redirect based on user role
     */
    private function redirectBasedOnRole(string $role): void
    {
        $redirects = [
            'admin' => '/admin/dashboard',
            'committee' => '/committee/dashboard',
            'student' => '/',
            'teacher' => '/'
        ];

        $redirect = $redirects[$role] ?? '/';
        $this->redirectTo($redirect);
    }

    /**
     * Set remember me cookie
     */
    private function setRememberMe(int $userId): void
    {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (86400 * 30); // 30 days

        // Store token in database (in production)
        // setcookie('remember_token', $token, $expires, '/', '', true, true);
        
        // For now, just set a simple cookie
        setcookie('remember_user', $userId, $expires, '/');
    }

    /**
     * Clear remember me cookie
     */
    private function clearRememberMe(): void
    {
        setcookie('remember_user', '', time() - 3600, '/');
    }

    /**
     * Check and auto-login from remember me cookie
     */
    public function checkRememberMe(): void
    {
        if (!Session::isLoggedIn() && isset($_COOKIE['remember_user'])) {
            $userId = (int) $_COOKIE['remember_user'];
            $user = $this->userModel->getById($userId);

            if ($user && $user['is_active']) {
                unset($user['password']);
                Session::login($user);
                $this->redirectBasedOnRole($user['role']);
            }
        }
    }
}
