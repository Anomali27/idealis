<?php
/**
 * Public Entry Point - PIC Social Activity & Volunteer Management System
 * Pontianak International College
 */

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Register autoloader
spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    
    // Check if the class uses the namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Get the relative class name
    $relativeClass = substr($class, $len);
    
    // Replace namespace separators with directory separators
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// Load required files
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Session.php';
require_once __DIR__ . '/../app/Core/Controller.php';

use App\Core\Router;

$router = new Router();

// =====================================================
// LANDING PAGE ROUTES
// =====================================================
$router->add('GET', '/', 'LandingController', 'index');
$router->add('GET', '/home', 'LandingController', 'index');

// =====================================================
// AUTH ROUTES (Simple - No Forgot Password)
// =====================================================
$router->add('GET', '/auth', 'AuthController', 'auth');
$router->add('GET', '/auth/login', 'AuthController', 'login');
$router->add('POST', '/auth/authenticate', 'AuthController', 'authenticate');
$router->add('GET', '/auth/logout', 'AuthController', 'logout');
$router->add('GET', '/auth/register', 'AuthController', 'register');
$router->add('POST', '/auth/store', 'AuthController', 'store');

// =====================================================
// STUDENT ROUTES
// =====================================================
$router->add('GET', '/student', 'StudentController', 'index');
$router->add('GET', '/student/{id}', 'StudentController', 'show');
$router->add('GET', '/student/dashboard', 'StudentController', 'dashboard');

// =====================================================
// ACTIVITY ROUTES
// =====================================================
$router->add('GET', '/activities', 'ActivityController', 'index');
$router->add('GET', '/activities/{id}', 'ActivityController', 'show');
$router->add('GET', '/activities/create', 'ActivityController', 'create');
$router->add('POST', '/activities/store', 'ActivityController', 'store');
$router->add('GET', '/activities/{id}/edit', 'ActivityController', 'edit');
$router->add('POST', '/activities/{id}/update', 'ActivityController', 'update');
$router->add('POST', '/activities/{id}/delete', 'ActivityController', 'delete');

// =====================================================
// VOLUNTEER ROUTES
// =====================================================
$router->add('GET', '/volunteers', 'VolunteerController', 'index');
$router->add('GET', '/volunteers/register/{activity_id}', 'VolunteerController', 'register');
$router->add('POST', '/volunteers/store', 'VolunteerController', 'store');
$router->add('GET', '/volunteers/history', 'VolunteerController', 'history');
$router->add('GET', '/volunteers/{id}', 'VolunteerController', 'show');
$router->add('GET', '/volunteers/{id}/confirm', 'VolunteerController', 'confirm');
$router->add('GET', '/volunteers/{id}/complete', 'VolunteerController', 'complete');
$router->add('GET', '/volunteers/{id}/reject', 'VolunteerController', 'reject');
$router->add('POST', '/volunteers/{id}/cancel', 'VolunteerController', 'cancel');
$router->add('POST', '/volunteers/{id}/delete', 'VolunteerController', 'delete');

// =====================================================
// DONATION ROUTES
// =====================================================
$router->add('GET', '/donations', 'DonationController', 'index');
$router->add('GET', '/donations/create/{activity_id}', 'DonationController', 'create');
$router->add('POST', '/donations/store', 'DonationController', 'store');
$router->add('GET', '/donations/history', 'DonationController', 'history');
$router->add('GET', '/donations/{id}/confirm', 'DonationController', 'confirm');
$router->add('GET', '/donations/{id}/reject', 'DonationController', 'reject');
$router->add('POST', '/donations/{id}/delete', 'DonationController', 'delete');

// =====================================================
// SUGGESTION ROUTES
// =====================================================
$router->add('GET', '/suggestions', 'SuggestionController', 'index');
$router->add('GET', '/suggestions/create', 'SuggestionController', 'create');
$router->add('POST', '/suggestions/store', 'SuggestionController', 'store');
$router->add('GET', '/suggestions/history', 'SuggestionController', 'history');
$router->add('GET', '/suggestions/{id}', 'SuggestionController', 'show');
$router->add('POST', '/suggestions/{id}/respond', 'SuggestionController', 'respond');
$router->add('GET', '/suggestions/{id}/implement', 'SuggestionController', 'implement');
$router->add('GET', '/suggestions/{id}/reject', 'SuggestionController', 'reject');
$router->add('POST', '/suggestions/{id}/delete', 'SuggestionController', 'delete');

// =====================================================
// ADMIN ROUTES
// =====================================================
$router->add('GET', '/admin', 'DashboardController', 'admin');
$router->add('GET', '/admin/dashboard', 'DashboardController', 'admin');
$router->add('GET', '/admin/users', 'UserController', 'index');
$router->add('GET', '/admin/users/create', 'UserController', 'create');
$router->add('POST', '/admin/users/store', 'UserController', 'store');
$router->add('GET', '/admin/users/{id}/edit', 'UserController', 'edit');
$router->add('POST', '/admin/users/{id}/update', 'UserController', 'update');
$router->add('POST', '/admin/users/{id}/delete', 'UserController', 'delete');

// =====================================================
// COMMITTEE ROUTES
// =====================================================
$router->add('GET', '/committee', 'DashboardController', 'committee');
$router->add('GET', '/committee/dashboard', 'DashboardController', 'committee');

// =====================================================
// DASHBOARD ROUTES
// =====================================================
$router->add('GET', '/dashboard', 'DashboardController', 'index');

// =====================================================
// API ROUTES (Optional - for AJAX)
// =====================================================
$router->add('GET', '/api/activities', 'ActivityController', 'apiIndex');
$router->add('GET', '/api/volunteers/{activity_id}', 'VolunteerController', 'apiByActivity');

// Run the router
$router->run();
