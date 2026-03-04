<?php
/**
 * Donation Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Donation;
use App\Models\Activity;

class DonationController extends Controller
{
    private Donation $donationModel;
    private Activity $activityModel;

    public function __construct()
    {
        parent::__construct();
        $this->donationModel = new Donation();
        $this->activityModel = new Activity();
    }

    /**
     * Show all donations (admin/committee only)
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

        $donations = $this->donationModel->getAll($filters);
        $activities = $this->activityModel->getUpcoming(50);
        
        // Get stats
        $totalAmount = $this->donationModel->getTotalAmount();
        $totalDonations = $this->donationModel->getCount();

        $this->data['title'] = 'Donations Management - PIC Social Activity';
        $this->data['donations'] = $donations;
        $this->data['activities'] = $activities;
        $this->data['filters'] = $filters;
        $this->data['statuses'] = Donation::getStatuses();
        $this->data['totalAmount'] = $totalAmount;
        $this->data['totalDonations'] = $totalDonations;

        $this->render('donations/index');
    }

    /**
     * Show donation form
     */
    public function create(int $activityId = null): void
    {
        // Require login
        AuthMiddleware::handle();

        $activity = null;
        if ($activityId) {
            $activity = $this->activityModel->getById($activityId);
        }

        // If no activity specified, show all activities for general donation
        if (!$activity) {
            $activities = $this->activityModel->getUpcoming(50);
        } else {
            $activities = [$activity];
        }

        $this->data['title'] = 'Make a Donation - PIC Social Activity';
        $this->data['activity'] = $activity;
        $this->data['activities'] = $activities;
        $this->data['paymentMethods'] = Donation::getPaymentMethods();
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('donations/create');
    }

    /**
     * Store donation
     */
    public function store(): void
    {
        // Require login for authenticated donation
        $isLoggedIn = Session::isLoggedIn();
        
        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/donations/create');
            return;
        }

        // Validate input
        $errors = $this->validateDonation($_POST);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/donations/create');
            return;
        }

        // Prepare data
        $data = [
            'user_id' => $isLoggedIn ? Session::getUserId() : null,
            'activity_id' => !empty($_POST['activity_id']) ? (int) $_POST['activity_id'] : null,
            'amount' => (float) $_POST['amount'],
            'donor_name' => trim($_POST['donor_name']),
            'donor_email' => trim($_POST['donor_email'] ?? ''),
            'payment_method' => $_POST['payment_method'],
            'payment_proof' => $_POST['payment_proof'] ?? null,
            'message' => trim($_POST['message'] ?? '')
        ];

        try {
            $donationId = $this->donationModel->create($data);

            if ($donationId > 0) {
                Session::setFlash('success', 'Thank you for your donation! Your donation is being processed.');
                $this->redirectTo('/donations/history');
            } else {
                Session::setFlash('error', 'Failed to process donation.');
                $this->redirectTo('/donations/create');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/donations/create');
        }
    }

    /**
     * Show user's donation history
     */
    public function history(): void
    {
        // Require login
        AuthMiddleware::handle();

        $userId = Session::getUserId();
        $donations = $this->donationModel->getByUser($userId);
        $totalDonated = $this->donationModel->getTotalAmount($userId);

        $this->data['title'] = 'My Donations - PIC Social Activity';
        $this->data['donations'] = $donations;
        $this->data['totalDonated'] = $totalDonated;

        $this->render('donations/history');
    }

    /**
     * Confirm donation (admin/committee)
     */
    public function confirm(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->donationModel->confirm($id);
            Session::setFlash('success', 'Donation has been confirmed.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/donations');
    }

    /**
     * Reject donation (admin/committee)
     */
    public function reject(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->donationModel->reject($id);
            Session::setFlash('success', 'Donation has been rejected.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/donations');
    }

    /**
     * Delete donation (admin only)
     */
    public function delete(int $id): void
    {
        // Require admin only
        AuthMiddleware::handleRole('admin');

        try {
            $this->donationModel->delete($id);
            Session::setFlash('success', 'Donation record has been deleted.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/donations');
    }

    /**
     * Validate donation input
     */
    private function validateDonation(array $data): array
    {
        $errors = [];

        // Donor name validation
        if (empty($data['donor_name'])) {
            $errors[] = 'Donor name is required.';
        } elseif (strlen($data['donor_name']) < 3) {
            $errors[] = 'Donor name must be at least 3 characters.';
        }

        // Amount validation
        if (empty($data['amount'])) {
            $errors[] = 'Donation amount is required.';
        } elseif ((float) $data['amount'] <= 0) {
            $errors[] = 'Donation amount must be greater than 0.';
        } elseif ((float) $data['amount'] > 100000000) {
            $errors[] = 'Donation amount is too large.';
        }

        // Payment method validation
        $validMethods = array_keys(Donation::getPaymentMethods());
        if (empty($data['payment_method'])) {
            $errors[] = 'Please select a payment method.';
        } elseif (!in_array($data['payment_method'], $validMethods)) {
            $errors[] = 'Invalid payment method selected.';
        }

        return $errors;
    }
}
