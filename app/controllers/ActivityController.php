<?php
/**
 * Activity Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Activity;
use App\Models\User;

class ActivityController extends Controller
{
    private Activity $activityModel;

    public function __construct()
    {
        parent::__construct();
        $this->activityModel = new Activity();
    }

    /**
     * Show all activities
     */
    public function index(): void
    {
        // Get filters
        $filters = [
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        // Get activities
        $activities = $this->activityModel->getAll($filters);

        $this->data['title'] = 'Activities - PIC Social Activity';
        $this->data['activities'] = $activities;
        $this->data['filters'] = $filters;
        $this->data['statuses'] = Activity::getStatuses();

        $this->render('activities/index');
    }

    /**
     * Show activity details
     */
    public function show(int $id): void
    {
        $activity = $this->activityModel->getById($id);

        if (!$activity) {
            $this->error404('Activity not found');
            return;
        }

        // Check if current user is registered
        $isRegistered = false;
        if (Session::isLoggedIn()) {
            $isRegistered = $this->activityModel->isUserRegistered($id, Session::getUserId());
        }

        $this->data['title'] = $activity['title'] . ' - PIC Social Activity';
        $this->data['activity'] = $activity;
        $this->data['isRegistered'] = $isRegistered;
        $this->data['isLoggedIn'] = Session::isLoggedIn();

        $this->render('activities/show');
    }

    /**
     * Show create activity form
     */
    public function create(): void
    {
        // Require login and admin/committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $this->data['title'] = 'Create Activity - PIC Social Activity';
        $this->data['statuses'] = Activity::getStatuses();
        $this->render('activities/create');
    }

    /**
     * Store new activity
     */
    public function store(): void
    {
        // Require login and admin/committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        // Validate input
        $errors = $this->validateActivity($_POST);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/activities/create');
            return;
        }

        // Prepare data
        $data = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description'] ?? ''),
            'activity_date' => $_POST['activity_date'],
            'activity_time' => $_POST['activity_time'],
            'location' => trim($_POST['location']),
            'max_volunteers' => (int) ($_POST['max_volunteers'] ?? 0),
            'status' => $_POST['status'] ?? 'draft',
            'requirements' => trim($_POST['requirements'] ?? ''),
            'created_by' => Session::getUserId()
        ];

        try {
            $activityId = $this->activityModel->create($data);

            if ($activityId > 0) {
                Session::setFlash('success', 'Activity created successfully!');
                $this->redirectTo('/activities');
            } else {
                Session::setFlash('error', 'Failed to create activity.');
                $this->redirectTo('/activities/create');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/activities/create');
        }
    }

    /**
     * Show edit activity form
     */
    public function edit(int $id): void
    {
        // Require login and admin/committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $activity = $this->activityModel->getById($id);

        if (!$activity) {
            $this->error404('Activity not found');
            return;
        }

        // Check ownership for committee (only admin can edit any)
        if (Session::hasRole('committee') && $activity['created_by'] != Session::getUserId()) {
            Session::setFlash('error', 'You can only edit your own activities.');
            $this->redirectTo('/activities');
            return;
        }

        $this->data['title'] = 'Edit Activity - PIC Social Activity';
        $this->data['activity'] = $activity;
        $this->data['statuses'] = Activity::getStatuses();
        $this->render('activities/edit');
    }

    /**
     * Update activity
     */
    public function update(int $id): void
    {
        // Require login and admin/committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $activity = $this->activityModel->getById($id);

        if (!$activity) {
            $this->error404('Activity not found');
            return;
        }

        // Check ownership for committee
        if (Session::hasRole('committee') && $activity['created_by'] != Session::getUserId()) {
            Session::setFlash('error', 'You can only edit your own activities.');
            $this->redirectTo('/activities');
            return;
        }

        // Validate input
        $errors = $this->validateActivity($_POST, $id);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/activities/' . $id . '/edit');
            return;
        }

        // Prepare data
        $data = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description'] ?? ''),
            'activity_date' => $_POST['activity_date'],
            'activity_time' => $_POST['activity_time'],
            'location' => trim($_POST['location']),
            'max_volunteers' => (int) ($_POST['max_volunteers'] ?? 0),
            'status' => $_POST['status'] ?? 'draft',
            'requirements' => trim($_POST['requirements'] ?? '')
        ];

        try {
            $success = $this->activityModel->update($id, $data);

            if ($success) {
                Session::setFlash('success', 'Activity updated successfully!');
                $this->redirectTo('/activities/' . $id);
            } else {
                Session::setFlash('error', 'Failed to update activity.');
                $this->redirectTo('/activities/' . $id . '/edit');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/activities/' . $id . '/edit');
        }
    }

    /**
     * Delete activity
     */
    public function delete(int $id): void
    {
        // Require login and admin role
        AuthMiddleware::handleRole('admin');

        $activity = $this->activityModel->getById($id);

        if (!$activity) {
            $this->error404('Activity not found');
            return;
        }

        try {
            $success = $this->activityModel->delete($id);

            if ($success) {
                Session::setFlash('success', 'Activity deleted successfully!');
            } else {
                Session::setFlash('error', 'Failed to delete activity.');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/activities');
    }

    /**
     * API: Get activities as JSON
     */
    public function apiIndex(): void
    {
        $activities = $this->activityModel->getUpcoming(10);
        $this->json([
            'success' => true,
            'data' => $activities
        ]);
    }

    /**
     * Validate activity input
     */
    private function validateActivity(array $data, int $excludeId = null): array
    {
        $errors = [];

        // Title validation
        if (empty($data['title'])) {
            $errors[] = 'Title is required.';
        } elseif (strlen($data['title']) < 5) {
            $errors[] = 'Title must be at least 5 characters.';
        } elseif (strlen($data['title']) > 200) {
            $errors[] = 'Title must not exceed 200 characters.';
        }

        // Date validation
        if (empty($data['activity_date'])) {
            $errors[] = 'Activity date is required.';
        } elseif (strtotime($data['activity_date']) < strtotime(date('Y-m-d')) && $excludeId === null) {
            $errors[] = 'Activity date cannot be in the past.';
        }

        // Time validation
        if (empty($data['activity_time'])) {
            $errors[] = 'Activity time is required.';
        }

        // Location validation
        if (empty($data['location'])) {
            $errors[] = 'Location is required.';
        }

        // Max volunteers validation
        if (!empty($data['max_volunteers']) && (int) $data['max_volunteers'] < 0) {
            $errors[] = 'Maximum volunteers cannot be negative.';
        }

        // Status validation
        $validStatuses = array_keys(Activity::getStatuses());
        if (!empty($data['status']) && !in_array($data['status'], $validStatuses)) {
            $errors[] = 'Invalid status selected.';
        }

        return $errors;
    }
}
