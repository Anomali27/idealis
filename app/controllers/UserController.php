<?php
/**
 * User Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\User;

class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }

    /**
     * Show all users (admin only)
     */
    public function index(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $filters = [
            'role' => $_GET['role'] ?? '',
            'search' => $_GET['search'] ?? '',
            'is_active' => true
        ];

        $page = max(1, (int)($_GET['page'] ?? 1));
        $users = $this->userModel->getPaginated($page, 25, $filters);

        $this->data['title'] = 'User Management - PIC Social Activity';
        $this->data['users'] = $users;
        $this->data['filters'] = $filters;
        $this->data['roles'] = User::getRoles();

        $this->render('admin/users');
    }

    /**
     * Show create user form (admin only)
     */
    public function create(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $this->data['title'] = 'Create User - PIC Social Activity';
        $this->data['roles'] = User::getRoles();
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('admin/users/create');
    }

    /**
     * Store new user (admin only)
     */
    public function store(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/admin/users/create');
            return;
        }

        // Validate input
        $errors = $this->validateUser($_POST);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/admin/users/create');
            return;
        }

        // Check if email exists
        if ($this->userModel->emailExists($_POST['email'])) {
            Session::setFlash('error', 'Email already exists.');
            $this->redirectTo('/admin/users/create');
            return;
        }

        // Check if NIS exists
        if (!empty($_POST['nis']) && $this->userModel->nisExists($_POST['nis'])) {
            Session::setFlash('error', 'NIS already exists.');
            $this->redirectTo('/admin/users/create');
            return;
        }

        // Prepare data
        $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => User::hashPassword($_POST['password']),
            'role' => $_POST['role'] ?? 'student',
            'nis' => !empty($_POST['nis']) ? trim($_POST['nis']) : null,
            'class' => !empty($_POST['class']) ? trim($_POST['class']) : null,
            'phone' => !empty($_POST['phone']) ? trim($_POST['phone']) : null,
            'avatar' => 'default.png',
            'is_active' => 1
        ];

        try {
            $userId = $this->userModel->create($data);

            if ($userId > 0) {
                Session::setFlash('success', 'User created successfully!');
                $this->redirectTo('/admin/users');
            } else {
                Session::setFlash('error', 'Failed to create user.');
                $this->redirectTo('/admin/users/create');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/admin/users/create');
        }
    }

    /**
     * Show edit user form (admin only)
     */
    public function edit(int $id): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->error404('User not found');
            return;
        }

        $this->data['title'] = 'Edit User - PIC Social Activity';
        $this->data['user'] = $user;
        $this->data['roles'] = User::getRoles();
        $this->data['csrf_token'] = Session::getCsrfToken();

        $this->render('admin/users/edit');
    }

    /**
     * Update user (admin only)
     */
    public function update(int $id): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->error404('User not found');
            return;
        }

        // Validate CSRF token
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!Session::validateCsrfToken($csrfToken)) {
            Session::setFlash('error', 'Invalid security token.');
            $this->redirectTo('/admin/users/' . $id . '/edit');
            return;
        }

        // Validate input
        $errors = $this->validateUser($_POST, $id);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/admin/users/' . $id . '/edit');
            return;
        }

        // Check if email exists (exclude current user)
        if ($this->userModel->emailExists($_POST['email'], $id)) {
            Session::setFlash('error', 'Email already exists.');
            $this->redirectTo('/admin/users/' . $id . '/edit');
            return;
        }

        // Check if NIS exists (exclude current user)
        if (!empty($_POST['nis']) && $this->userModel->nisExists($_POST['nis'], $id)) {
            Session::setFlash('error', 'NIS already exists.');
            $this->redirectTo('/admin/users/' . $id . '/edit');
            return;
        }

        // Prepare data
        $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'role' => $_POST['role'] ?? 'student',
            'nis' => !empty($_POST['nis']) ? trim($_POST['nis']) : null,
            'class' => !empty($_POST['class']) ? trim($_POST['class']) : null,
            'phone' => !empty($_POST['phone']) ? trim($_POST['phone']) : null
        ];

        // Update password if provided
        if (!empty($_POST['password'])) {
            $data['password'] = User::hashPassword($_POST['password']);
        }

        try {
            $success = $this->userModel->update($id, $data);

            if ($success) {
                Session::setFlash('success', 'User updated successfully!');
                $this->redirectTo('/admin/users');
            } else {
                Session::setFlash('error', 'Failed to update user.');
                $this->redirectTo('/admin/users/' . $id . '/edit');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/admin/users/' . $id . '/edit');
        }
    }

    /**
     * Delete user (admin only - soft delete)
     */
    public function delete(int $id): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->error404('User not found');
            return;
        }

        // Prevent deleting own account
        if ($id === Session::getUserId()) {
            Session::setFlash('error', 'You cannot delete your own account.');
            $this->redirectTo('/admin/users');
            return;
        }

        try {
            $success = $this->userModel->delete($id);

            if ($success) {
                Session::setFlash('success', 'User deleted successfully!');
            } else {
                Session::setFlash('error', 'Failed to delete user.');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
        }

        $this->redirectTo('/admin/users');
    }

    /**
     * Update user role via AJAX (admin only)
     */
    public function updateRole(int $id): void
    {
        AuthMiddleware::handleRole('admin');

        // Must be AJAX/JSON request
        $input = json_decode(file_get_contents('php://input'), true);
        $newRole = $input['role'] ?? '';

        $validRoles = ['student', 'admin', 'teacher'];
        if (!in_array($newRole, $validRoles)) {
            $this->json(['success' => false, 'message' => 'Invalid role.'], 400);
            return;
        }

        $user = $this->userModel->getById($id);
        if (!$user) {
            $this->json(['success' => false, 'message' => 'User not found.'], 404);
            return;
        }

        $oldRole = $user['role'];

        // Prevent removing last admin
        if ($oldRole === 'admin' && $newRole !== 'admin') {
            $adminCount = $this->db->queryOne("SELECT COUNT(*) as cnt FROM users WHERE role = 'admin' AND is_active = 1");
            if (($adminCount['cnt'] ?? 0) <= 1) {
                $this->json(['success' => false, 'message' => 'Cannot change role: this is the last admin account.'], 403);
                return;
            }
        }

        try {
            $this->userModel->update($id, ['role' => $newRole]);

            // Audit log
            $this->db->execute(
                "INSERT INTO role_audit_log (user_id, changed_by, old_role, new_role) VALUES (?, ?, ?, ?)",
                [$id, Session::getUserId(), $oldRole, $newRole]
            );

            $this->json(['success' => true, 'message' => "Role changed from {$oldRole} to {$newRole}.", 'old_role' => $oldRole, 'new_role' => $newRole]);
        } catch (\Exception $e) {
            $this->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Profile page - show user info + event history
     */
    public function profile(): void
    {
        AuthMiddleware::handle();

        $userId = Session::getUserId();
        $userModel = new User();
        $activityModel = new Activity();
        
        $user = $userModel->getById($userId);
        $activities = $activityModel->getAll(); // Fake history from activities

        $this->data['title'] = 'Profile & Settings - PIC Social Activity';
        $this->data['user'] = $user;
        $this->data['activities'] = $activities;
        $this->data['roleLabel'] = User::getRoleLabel($user['role'] ?? '');

        $this->render('profile/index');
    }

    /**
     * Validate user input
     */
    private function validateUser(array $data, int $excludeId = null): array
    {
        $errors = [];

        // Name validation
        if (empty($data['name'])) {
            $errors[] = 'Name is required.';
        } elseif (strlen($data['name']) < 3) {
            $errors[] = 'Name must be at least 3 characters.';
        }

        // Email validation
        if (empty($data['email'])) {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        // Password validation (only for new user or when changing password)
        if ($excludeId === null && empty($data['password'])) {
            $errors[] = 'Password is required.';
        } elseif (!empty($data['password']) && strlen($data['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }

        // Role validation
        $validRoles = array_keys(User::getRoles());
        if (!empty($data['role']) && !in_array($data['role'], $validRoles)) {
            $errors[] = 'Invalid role selected.';
        }

        return $errors;
    }
}

