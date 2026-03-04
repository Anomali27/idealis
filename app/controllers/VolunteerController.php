<?php
/**
 * Volunteer Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Volunteer;
use App\Models\Activity;

class VolunteerController extends Controller
{
    private Volunteer $volunteerModel;
    private Activity $activityModel;

    public function __construct()
    {
        parent::__construct();
        $this->volunteerModel = new Volunteer();
        $this->activityModel = new Activity();
    }

    /**
     * Show all volunteers (admin/committee only)
     */
    public function index(): void
    {
        // Require admin or committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $filters = [
            'activity_id' => $_GET['activity_id'] ?? '',
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        $volunteers = $this->volunteerModel->getAll($filters);
        $activities = $this->activityModel->getUpcoming(50);

        $this->data['title'] = 'Volunteers Management - PIC Social Activity';
        $this->data['volunteers'] = $volunteers;
        $this->data['activities'] = $activities;
        $this->data['filters'] = $filters;
        $this->data['statuses'] = Volunteer::getStatuses();

        $this->render('volunteers/index');
    }

    /**
     * Show volunteer details
     */
    public function show(int $id): void
    {
        // Require login
        AuthMiddleware::handle();

        $volunteer = $this->volunteerModel->getById($id);

        if (!$volunteer) {
            $this->error404('Volunteer record not found');
            return;
        }

        // Check if user owns this record or is admin/committee
        $userId = Session::getUserId();
        $userRole = Session::getUserRole();

        if ($volunteer['user_id'] != $userId && !in_array($userRole, ['admin', 'committee'])) {
            $this->error403('You do not have permission to view this record');
            return;
        }

        $this->data['title'] = 'Volunteer Details - PIC Social Activity';
        $this->data['volunteer'] = $volunteer;

        $this->render('volunteers/show');
    }

    /**
     * Show volunteer registration form
     */
    public function register(int $activityId): void
    {
        // Require login
        AuthMiddleware::handle();

        $activity = $this->activityModel->getById($activityId);

        if (!$activity) {
            $this->error404('Activity not found');
            return;
        }

        // Check if already registered
        $userId = Session::getUserId();
        if ($this->volunteerModel->isRegistered($activityId, $userId)) {
            Session::setFlash('error', 'You are already registered for this activity.');
            $this->redirectTo('/activities/' . $activityId);
            return;
        }

        // Check if activity is still open
        if (!in_array($activity['status'], ['upcoming', 'ongoing'])) {
            Session::setFlash('error', 'Registration is closed for this activity.');
            $this->redirectTo('/activities/' . $activityId);
            return;
        }

        // Check if activity is full
        $currentCount = $this->volunteerModel->getCountByActivity($activityId);
        if ($activity['max_volunteers'] > 0 && $currentCount >= $activity['max_volunteers']) {
            Session::setFlash('error', 'This activity is already full.');
            $this->redirectTo('/activities/' . $activityId);
            return;
        }

        $this->data['title'] = 'Register as Volunteer - PIC Social Activity';
        $this->data['activity'] = $activity;
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('volunteers/register');
    }

    /**
     * Store volunteer registration
     */
    public function store(): void
    {
        // Require login
        AuthMiddleware::handle();

        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/activities');
            return;
        }

        $activityId = (int) ($_POST['activity_id'] ?? 0);
        $notes = trim($_POST['notes'] ?? '');

        if ($activityId <= 0) {
            Session::setFlash('error', 'Invalid activity.');
            $this->redirectTo('/activities');
            return;
        }

        $activity = $this->activityModel->getById($activityId);

        if (!$activity) {
            Session::setFlash('error', 'Activity not found.');
            $this->redirectTo('/activities');
            return;
        }

        // Check if already registered
        $userId = Session::getUserId();
        if ($this->volunteerModel->isRegistered($activityId, $userId)) {
            Session::setFlash('error', 'You are already registered for this activity.');
            $this->redirectTo('/activities/' . $activityId);
            return;
        }

        // Check if activity is full
        $currentCount = $this->volunteerModel->getCountByActivity($activityId);
        if ($activity['max_volunteers'] > 0 && $currentCount >= $activity['max_volunteers']) {
            Session::setFlash('error', 'This activity is already full.');
            $this->redirectTo('/activities/' . $activityId);
            return;
        }

        try {
            $this->volunteerModel->register($userId, $activityId, $notes);
            Session::setFlash('success', 'You have successfully registered as a volunteer!');
            $this->redirectTo('/volunteers/history');
        } catch (\Exception $e) {
            Session::setFlash('error', $e->getMessage());
            $this->redirectTo('/activities/' . $activityId);
        }
    }

    /**
     * Show volunteer history (for logged in user)
     */
    public function history(): void
    {
        // Require login
        AuthMiddleware::handle();

        $userId = Session::getUserId();
        $history = $this->volunteerModel->getHistory($userId);

        // Calculate stats
        $totalActivities = count($history);
        $completedActivities = count(array_filter($history, fn($h) => $h['volunteer_status'] === 'completed'));

        $this->data['title'] = 'My Volunteer History - PIC Social Activity';
        $this->data['history'] = $history;
        $this->data['totalActivities'] = $totalActivities;
        $this->data['completedActivities'] = $completedActivities;

        $this->render('volunteers/history');
    }

    /**
     * Cancel volunteer registration
     */
    public function cancel(int $id): void
    {
        // Require login
        AuthMiddleware::handle();

        $volunteer = $this->volunteerModel->getById($id);

        if (!$volunteer) {
            $this->error404('Volunteer record not found');
            return;
        }

        // Check ownership
        $userId = Session::getUserId();
        $userRole = Session::getUserRole();

        if ($volunteer['user_id'] != $userId && !in_array($userRole, ['admin', 'committee'])) {
            $this->error403('You do not have permission to cancel this registration');
            return;
        }

        try {
            $this->volunteerModel->cancel($id);
            Session::setFlash('success', 'Your registration has been cancelled.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        // Redirect based on role
        if (in_array($userRole, ['admin', 'committee'])) {
            $this->redirectTo('/volunteers');
        } else {
            $this->redirectTo('/volunteers/history');
        }
    }

    /**
     * Confirm volunteer (admin/committee)
     */
    public function confirm(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->volunteerModel->confirm($id);
            Session::setFlash('success', 'Volunteer has been confirmed.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/volunteers?activity_id=' . ($_GET['activity_id'] ?? ''));
    }

    /**
     * Complete volunteer (admin/committee)
     */
    public function complete(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->volunteerModel->complete($id);
            Session::setFlash('success', 'Volunteer has been marked as completed.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/volunteers?activity_id=' . ($_GET['activity_id'] ?? ''));
    }

    /**
     * Reject volunteer (admin/committee)
     */
    public function reject(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->volunteerModel->reject($id);
            Session::setFlash('success', 'Volunteer has been rejected.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/volunteers?activity_id=' . ($_GET['activity_id'] ?? ''));
    }

    /**
     * Delete volunteer record (admin only)
     */
    public function delete(int $id): void
    {
        // Require admin only
        AuthMiddleware::handleRole('admin');

        try {
            $this->volunteerModel->delete($id);
            Session::setFlash('success', 'Volunteer record has been deleted.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/volunteers');
    }

    /**
     * API: Get volunteers by activity
     */
    public function apiByActivity(int $activityId): void
    {
        $volunteers = $this->volunteerModel->getByActivity($activityId);
        $this->json([
            'success' => true,
            'data' => $volunteers,
            'count' => count($volunteers)
        ]);
    }
}
