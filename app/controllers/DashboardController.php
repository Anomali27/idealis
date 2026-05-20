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

        $suggestionModel = new \App\Models\Suggestion();
        $eventModel = new \App\Models\Event();
        $userModel = new \App\Models\User();
        $volunteerModel = new \App\Models\Volunteer();
        $donationModel = new \App\Models\Donation();

        // Query counts & data
        $totalUsers = $userModel->getActiveCount();
        $allEvents = $eventModel->getAll();
        $totalEvents = count($allEvents);
        
        $pendingSuggestions = $suggestionModel->getPendingCount();
        $allSuggestions = $suggestionModel->getAll();
        $totalSuggestions = count($allSuggestions);

        // Fetch all users
        $allUsers = $userModel->getAll();

        // Add donation totals and volunteer counts to events dynamically
        $eventsData = [];
        foreach ($allEvents as $event) {
            $volCount = $volunteerModel->getCountByActivity($event['id']) ?? 0;
            $donTotal = $donationModel->getTotalAmount($event['id']) ?? 0;
            
            $event['volunteer_count'] = $volCount;
            $event['collected_donation'] = $donTotal;
            $eventsData[] = $event;
        }

        // Fetch detailed volunteers list
        $db = \App\Core\Database::getInstance();
        $volunteers = $db->query("
            SELECT 
                ep.id,
                ep.created_at,
                u.name as user_name,
                u.email as user_email,
                u.role as user_role,
                e.id as event_id,
                e.name as event_name,
                e.date as event_date
            FROM event_participants ep
            JOIN users u ON ep.user_id = u.id
            JOIN events e ON ep.event_id = e.id
            ORDER BY ep.created_at DESC
        ");

        // Fetch detailed donations list
        $donations = $db->query("
            SELECT 
                d.*,
                e.name as event_name
            FROM donations d
            LEFT JOIN events e ON d.activity_id = e.id
            ORDER BY d.donated_at DESC
        ");

        // Prepare view data
        $this->data['title'] = 'Admin Dashboard - PIC Social Activity';
        $this->data['totalUsers'] = $totalUsers;
        $this->data['totalEvents'] = $totalEvents;
        $this->data['totalSuggestions'] = $totalSuggestions;
        $this->data['pendingSuggestions'] = $pendingSuggestions;
        
        $this->data['allUsers'] = $allUsers;
        $this->data['allEvents'] = $eventsData;
        $this->data['allSuggestions'] = $allSuggestions;
        $this->data['volunteers'] = $volunteers;
        $this->data['donations'] = $donations;
        
        $this->data['userName'] = Session::getUserName();

        $this->render('admin/dashboard');
    }
}
