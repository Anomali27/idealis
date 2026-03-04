<?php
/**
 * Suggestion Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Suggestion;

class SuggestionController extends Controller
{
    private Suggestion $suggestionModel;

    public function __construct()
    {
        parent::__construct();
        $this->suggestionModel = new Suggestion();
    }

    /**
     * Show all suggestions (admin/committee only)
     */
    public function index(): void
    {
        // Require admin or committee role
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $filters = [
            'status' => $_GET['status'] ?? '',
            'category' => $_GET['category'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        $suggestions = $this->suggestionModel->getAll($filters);
        
        // Get stats
        $pendingCount = $this->suggestionModel->getPendingCount();

        $this->data['title'] = 'Suggestions Management - PIC Social Activity';
        $this->data['suggestions'] = $suggestions;
        $this->data['filters'] = $filters;
        $this->data['statuses'] = Suggestion::getStatuses();
        $this->data['categories'] = Suggestion::getCategories();
        $this->data['pendingCount'] = $pendingCount;

        $this->render('suggestions/index');
    }

    /**
     * Show create suggestion form
     */
    public function create(): void
    {
        // Require login
        AuthMiddleware::handle();

        $this->data['title'] = 'Submit Suggestion - PIC Social Activity';
        $this->data['categories'] = Suggestion::getCategories();
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('suggestions/create');
    }

    /**
     * Store suggestion
     */
    public function store(): void
    {
        // Require login
        AuthMiddleware::handle();

        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/suggestions/create');
            return;
        }

        // Validate input
        $errors = $this->validateSuggestion($_POST);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/suggestions/create');
            return;
        }

        // Prepare data
        $data = [
            'user_id' => Session::getUserId(),
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description']),
            'category' => $_POST['category'] ?? 'general'
        ];

        try {
            $suggestionId = $this->suggestionModel->create($data);

            if ($suggestionId > 0) {
                Session::setFlash('success', 'Thank you for your suggestion! We will review it shortly.');
                $this->redirectTo('/suggestions/history');
            } else {
                Session::setFlash('error', 'Failed to submit suggestion.');
                $this->redirectTo('/suggestions/create');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/suggestions/create');
        }
    }

    /**
     * Show user's suggestion history
     */
    public function history(): void
    {
        // Require login
        AuthMiddleware::handle();

        $userId = Session::getUserId();
        $suggestions = $this->suggestionModel->getByUser($userId);
        $totalSuggestions = $this->suggestionModel->getCountByUser($userId);

        $this->data['title'] = 'My Suggestions - PIC Social Activity';
        $this->data['suggestions'] = $suggestions;
        $this->data['totalSuggestions'] = $totalSuggestions;

        $this->render('suggestions/history');
    }

    /**
     * Show suggestion detail
     */
    public function show(int $id): void
    {
        // Require login
        AuthMiddleware::handle();

        $suggestion = $this->suggestionModel->getById($id);

        if (!$suggestion) {
            $this->error404('Suggestion not found');
            return;
        }

        // Check ownership for non-admin
        $userId = Session::getUserId();
        $userRole = Session::getUserRole();

        if ($suggestion['user_id'] != $userId && !in_array($userRole, ['admin', 'committee'])) {
            $this->error403('You do not have permission to view this suggestion');
            return;
        }

        $this->data['title'] = 'Suggestion Details - PIC Social Activity';
        $this->data['suggestion'] = $suggestion;

        $this->render('suggestions/show');
    }

    /**
     * Add response to suggestion (admin/committee)
     */
    public function respond(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        $suggestion = $this->suggestionModel->getById($id);

        if (!$suggestion) {
            $this->error404('Suggestion not found');
            return;
        }

        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/suggestions');
            return;
        }

        $response = trim($_POST['response'] ?? '');

        if (empty($response)) {
            Session::setFlash('error', 'Response cannot be empty.');
            $this->redirectTo('/suggestions');
            return;
        }

        try {
            $this->suggestionModel->addResponse($id, $response);
            Session::setFlash('success', 'Response added successfully.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/suggestions');
    }

    /**
     * Mark suggestion as implemented (admin/committee)
     */
    public function implement(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->suggestionModel->updateStatus($id, 'implemented');
            Session::setFlash('success', 'Suggestion marked as implemented.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/suggestions');
    }

    /**
     * Reject suggestion (admin/committee)
     */
    public function reject(int $id): void
    {
        // Require admin or committee
        AuthMiddleware::handleAnyRole(['admin', 'committee']);

        try {
            $this->suggestionModel->updateStatus($id, 'rejected');
            Session::setFlash('success', 'Suggestion rejected.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/suggestions');
    }

    /**
     * Delete suggestion (admin only)
     */
    public function delete(int $id): void
    {
        // Require admin only
        AuthMiddleware::handleRole('admin');

        try {
            $this->suggestionModel->delete($id);
            Session::setFlash('success', 'Suggestion deleted.');
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/suggestions');
    }

    /**
     * Validate suggestion input
     */
    private function validateSuggestion(array $data): array
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

        // Description validation
        if (empty($data['description'])) {
            $errors[] = 'Description is required.';
        } elseif (strlen($data['description']) < 10) {
            $errors[] = 'Description must be at least 10 characters.';
        }

        // Category validation
        $validCategories = array_keys(Suggestion::getCategories());
        if (!empty($data['category']) && !in_array($data['category'], $validCategories)) {
            $errors[] = 'Invalid category selected.';
        }

        return $errors;
    }
}
