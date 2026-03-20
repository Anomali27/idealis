<?php
/**
 * Dashboard Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Activity;
use App\Models\Volunteer;
use App\Models\Donation;
use App\Models\Suggestion;
use App\Models\User;

class DashboardController extends Controller
{
    private Activity $activityModel;
    private Volunteer $volunteerModel;
    private Donation $donationModel;
    private Suggestion $suggestionModel;
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->activityModel = new Activity();
        $this->volunteerModel = new Volunteer();
        $this->donationModel = new Donation();
        $this->suggestionModel = new Suggestion();
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
        $userId = Session::getUserId();

        // Redirect based on role
        switch ($userRole) {
            case 'admin':
                $this->redirectTo('/admin/dashboard');
                break;
            case 'committee':
                $this->redirectTo('/committee/dashboard');
                break;
            default:
                // Student dashboard - show volunteer history
                $history = $this->volunteerModel->getHistory($userId);
                $totalActivities = count($history);
                $completedActivities = count(array_filter($history, fn($h) => $h['volunteer_status'] === 'completed'));

                $this->data['title'] = 'Dashboard - PIC Social Activity';
                $this->data['history'] = $history;
                $this->data['totalActivities'] = $totalActivities;
                $this->data['completedActivities'] = $completedActivities;
                $this->data['userName'] = Session::getUserName();

                $this->render('student/dashboard');
                break;
        }
    }

    /**
     * Admin Dashboard
     */
    public function admin(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        // Get statistics
        $activityStats = $this->activityModel->getStats();
        $totalUsers = $this->userModel->getActiveCount();
        $pendingSuggestions = $this->suggestionModel->getPendingCount();

        // Get recent activities
        $recentActivities = $this->activityModel->getUpcoming(5);

        // Get recent volunteers
        $recentVolunteers = $this->volunteerModel->getPaginated(1, 5);

        // Get recent donations
        $recentDonations = $this->donationModel->getPaginated(1, 5);

        // Calculate totals
        $totalDonations = $this->donationModel->getTotalAmount();
        $totalVolunteers = $activityStats['total_volunteers'] ?? 0;

        $this->data['title'] = 'Admin Dashboard - PIC Social Activity';
        $this->data['activityStats'] = $activityStats;
        $this->data['totalUsers'] = $totalUsers;
        $this->data['pendingSuggestions'] = $pendingSuggestions;
        $this->data['recentActivities'] = $recentActivities['data'] ?? $recentActivities;
        $this->data['recentVolunteers'] = $recentVolunteers['data'] ?? [];
        $this->data['recentDonations'] = $recentDonations['data'] ?? [];
        $this->data['totalDonations'] = $totalDonations;
        $this->data['totalVolunteers'] = $totalVolunteers;
        $this->data['userName'] = Session::getUserName();

        $this->render('admin/dashboard');
    }

    /**
     * Committee Dashboard
     */
    public function committee(): void
    {
        // Require committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $userId = Session::getUserId();
        $userRole = Session::getUserRole();

        // Get activities created by this committee
        $myActivities = $this->activityModel->getByCreator($userId);

        // Calculate stats for committee's activities
        $totalActivities = count($myActivities);
        $upcomingActivities = count(array_filter($myActivities, fn($a) => $a['status'] === 'upcoming'));

        // Get volunteers for committee's activities
        $volunteers = [];
        foreach ($myActivities as $activity) {
            $activityVolunteers = $this->volunteerModel->getByActivity($activity['id']);
            $volunteers = array_merge($volunteers, $activityVolunteers);
        }
        $totalVolunteers = count($volunteers);

        // Get donations for committee's activities
        $totalDonations = 0;
        foreach ($myActivities as $activity) {
            $totalDonations += $this->donationModel->getTotalAmount($activity['id']);
        }

        $this->data['title'] = 'Committee Dashboard - PIC Social Activity';
        $this->data['myActivities'] = $myActivities;
        $this->data['totalActivities'] = $totalActivities;
        $this->data['upcomingActivities'] = $upcomingActivities;
        $this->data['totalVolunteers'] = $totalVolunteers;
        $this->data['totalDonations'] = $totalDonations;
        $this->data['volunteers'] = $volunteers;
        $this->data['userName'] = Session::getUserName();
        $this->data['isAdmin'] = ($userRole === 'admin');

        $this->render('committee/dashboard');
    }
}
