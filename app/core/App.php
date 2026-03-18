<?php
/**
 * App Core - Main Application Bootstrap
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Core;

use App\Controllers\ActivityController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\DonationController;
use App\Controllers\LandingController;
use App\Controllers\StudentController;
use App\Controllers\SuggestionController;
use App\Controllers\UserController;
use App\Controllers\VolunteerController;

class App
{
    protected Router $router;
    protected static array $controllers = [];

    public function __construct()
    {
        Session::init();
        
        $this->router = new Router();

        // Define routes
        $this->registerRoutes();

        // Run router
        $this->router->run();
    }

    protected function registerRoutes(): void
    {
        $router = $this->router;

        // Landing
        $router->add('GET', '/', 'LandingController', 'index');

        // Auth
        $router->add('GET', '/auth/login', 'AuthController', 'login');
        $router->add('GET', '/auth/register', 'AuthController', 'register');
        $router->add('GET', '/auth/auth', 'AuthController', 'auth');
        $router->add('POST', '/auth/authenticate', 'AuthController', 'authenticate');
        $router->add('POST', '/auth/store', 'AuthController', 'store');
        $router->add('GET', '/logout', 'AuthController', 'logout');

        // Profile (NEW)
        $router->add('GET', '/profile', 'UserController', 'profile');

        // Activities
        $router->add('GET', '/activities', 'ActivityController', 'index');
        $router->add('GET', '/activities/create', 'ActivityController', 'create');
        $router->add('POST', '/activities/store', 'ActivityController', 'store');
        $router->add('GET', '/activities/{id}/edit', 'ActivityController', 'edit');
        $router->add('POST', '/activities/{id}/update', 'ActivityController', 'update');
        $router->add('GET', '/activities/{id}', 'ActivityController', 'show');
        $router->add('POST', '/activities/{id}/delete', 'ActivityController', 'delete');

        // Volunteers
        $router->add('GET', '/volunteers', 'VolunteerController', 'index');
        $router->add('GET', '/volunteers/history', 'VolunteerController', 'history');
        $router->add('GET', '/volunteers/register', 'VolunteerController', 'register');

        // Donations
        $router->add('GET', '/donations', 'DonationController', 'index');
        $router->add('GET', '/donations/create', 'DonationController', 'create');
        $router->add('GET', '/donations/history', 'DonationController', 'history');

        // Suggestions
        $router->add('GET', '/suggestions', 'SuggestionController', 'index');
        $router->add('GET', '/suggestions/create', 'SuggestionController', 'create');
        $router->add('GET', '/suggestions/history', 'SuggestionController', 'history');

        // Admin
        $router->add('GET', '/admin/dashboard', 'DashboardController', 'admin');
        $router->add('GET', '/admin/users', 'UserController', 'index');

        // Committee
        $router->add('GET', '/committee/dashboard', 'DashboardController', 'committee');

        // Default dashboard
        $router->add('GET', '/dashboard', 'DashboardController', 'index');
    }
}
