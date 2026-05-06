<?php
/**
 * Dashboard Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Event;
use App\Models\User;

class DashboardController extends Controller
{
    private Event $eventModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->eventModel = new Event();
        $this->userModel = new User();
    }

    /**
     * Main dashboard - shows different views based on role
     */
    public function index(): void
    {
        // Require login
        AuthMiddleware::handle();

        $userRole = Session::getUserRole();

        // Redirect based on role
        if ($userRole === 'admin') {
            $this->redirectTo('/admin/dashboard');
        } else {
            // For now, non-admins just go to the events page as their 'dashboard'
            // or we could show a simple profile page. Let's redirect to events.
            Session::setFlash('success', 'Welcome back! Here are the latest events.');
            $this->redirectTo('/events');
        }
    }

    /**
     * Admin Dashboard
     */
    public function admin(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $totalUsers = $this->userModel->getActiveCount();

        // Get recent events (simplified)
        $recentEvents = $this->eventModel->getAll();

        $this->data['title'] = 'Admin Dashboard - PIC Social Activity';
        $this->data['totalUsers'] = $totalUsers;
        $this->data['recentEvents'] = array_slice($recentEvents, 0, 5);
        $this->data['userName'] = Session::getUserName();

        $this->render('admin/dashboard');
    }
}
