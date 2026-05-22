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

        // Redirect to new admin dashboard users tab
        $this->redirectTo('/admin/dashboard?tab=users');
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

        $this->render('admin/create');
    }

    /**
     * Store new user (admin only)
     */
    public function store(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        // Validate input
        $errors = $this->validateUser($_POST);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/admin/create');
            return;
        }

        $role = $_POST['role'] ?? 'student';

        // Check if email exists
        if ($this->userModel->emailExists($_POST['email'])) {
            Session::setFlash('error', 'Email already exists.');
            $this->redirectTo('/admin/create');
            return;
        }

        // Check if NIS exists (only for students)
        if ($role === 'student' && !empty($_POST['nis']) && $this->userModel->nisExists($_POST['nis'])) {
            Session::setFlash('error', 'NIS already exists.');
            $this->redirectTo('/admin/create');
            return;
        }

        // Prepare data
        $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'password' => User::hashPassword($_POST['password']),
            'role' => $role,
            'nis' => ($role === 'student' && !empty($_POST['nis'])) ? trim($_POST['nis']) : null,
            'class' => ($role === 'student' && !empty($_POST['class'])) ? trim($_POST['class']) : null,
            'major' => ($role === 'student' && !empty($_POST['major'])) ? trim($_POST['major']) : null,
            'phone' => !empty($_POST['phone']) ? trim($_POST['phone']) : null,
            'avatar' => 'default.png',
            'is_active' => isset($_POST['is_active']) ? (int) $_POST['is_active'] : 1
        ];

        try {
            $userId = $this->userModel->create($data);

            if ($userId > 0) {
                Session::setFlash('success', 'User created successfully!');
                $this->redirectTo('/admin/dashboard?tab=users');
            } else {
                Session::setFlash('error', 'Failed to create user.');
                $this->redirectTo('/admin/create');
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/admin/create');
        }
    }

    /**
     * Show edit user form (admin only)
     */
    public function edit(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $id = (int) ($_GET['id'] ?? 0);
        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->error404('User not found');
            return;
        }

        $this->data['title'] = 'Edit User - PIC Social Activity';
        $this->data['user'] = $user;
        $this->data['roles'] = User::getRoles();

        $this->render('admin/edit');
    }

    /**
     * Update user (admin only)
     */
    public function update(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $id = (int) ($_POST['id'] ?? 0);
        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->error404('User not found');
            return;
        }

        // Validate input
        $errors = $this->validateUser($_POST, $id);

        if (!empty($errors)) {
            Session::setFlash('error', implode('<br>', $errors));
            $this->redirectTo('/admin/edit?id=' . $id);
            return;
        }

        $role = $_POST['role'] ?? 'student';

        // Check if email exists (exclude current user)
        if ($this->userModel->emailExists($_POST['email'], $id)) {
            Session::setFlash('error', 'Email already exists.');
            $this->redirectTo('/admin/edit?id=' . $id);
            return;
        }

        // Check if NIS exists (exclude current user - only for students)
        if ($role === 'student' && !empty($_POST['nis']) && $this->userModel->nisExists($_POST['nis'], $id)) {
            Session::setFlash('error', 'NIS already exists.');
            $this->redirectTo('/admin/edit?id=' . $id);
            return;
        }

        // Prepare data
        $data = [
            'name' => trim($_POST['name']),
            'email' => trim($_POST['email']),
            'role' => $role,
            'nis' => ($role === 'student' && !empty($_POST['nis'])) ? trim($_POST['nis']) : null,
            'class' => ($role === 'student' && !empty($_POST['class'])) ? trim($_POST['class']) : null,
            'major' => ($role === 'student' && !empty($_POST['major'])) ? trim($_POST['major']) : null,
            'phone' => !empty($_POST['phone']) ? trim($_POST['phone']) : null,
            'is_active' => isset($_POST['is_active']) ? (int) $_POST['is_active'] : 1
        ];

        // Update password if provided
        if (!empty($_POST['password'])) {
            $data['password'] = User::hashPassword($_POST['password']);
        }

        try {
            $success = $this->userModel->update($id, $data);

            if ($success) {
                Session::setFlash('success', 'User updated successfully!');
                $this->redirectTo('/admin/dashboard?tab=users');
            } else {
                Session::setFlash('error', 'Failed to update user.');
                $this->redirectTo('/admin/edit?id=' . $id);
            }
        } catch (\Exception $e) {
            Session::setFlash('error', 'Error: ' . $e->getMessage());
            $this->redirectTo('/admin/edit?id=' . $id);
        }
    }

    /**
     * Delete user (admin only - soft delete)
     */
    public function delete(): void
    {
        // Require admin role
        AuthMiddleware::handleRole('admin');

        $id = (int) ($_POST['id'] ?? 0);
        $user = $this->userModel->getById($id);

        if (!$user) {
            $this->error404('User not found');
            return;
        }

        // Prevent deleting own account
        if ($id === Session::getUserId()) {
            Session::setFlash('error', 'You cannot delete your own account.');
            $this->redirectTo('/admin/dashboard?tab=users');
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

        $this->redirectTo('/admin/dashboard?tab=users');
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
     * History page - show user info + event history
     */
    public function history(): void
    {
        AuthMiddleware::handle();

        $userId = Session::getUserId();
        $userModel = new User();
        $eventModel = new \App\Models\Event();

        $user = $userModel->getById($userId);
        $events = $eventModel->getUserEvents($userId);
        $donations = $eventModel->getUserDonations($userId);

        $suggestionModel = new \App\Models\Suggestion();
        $suggestions = $suggestionModel->getByUser($userId);
        $totalSuggestions = $suggestionModel->getCountByUser($userId);

        // Calculate stats
        $totalEvents = count($events);
        $totalDonations = array_reduce($donations, function ($carry, $item) {
            return $carry + ($item['amount'] ?? 0);
        }, 0);

        // Calculate volunteer hours (assume 5 hours per completed event)
        $totalVolunteerHours = 0;
        $today = date('Y-m-d');
        foreach ($events as $event) {
            if ($event['date'] < $today) {
                $totalVolunteerHours += 5;
            }
        }

        $this->data['title'] = 'User Activity & Donation History - PIC Social Activity';
        $this->data['user'] = $user;
        $this->data['events'] = $events;
        $this->data['donations'] = $donations;
        $this->data['suggestions'] = $suggestions;
        $this->data['totalEvents'] = $totalEvents;
        $this->data['totalVolunteerHours'] = $totalVolunteerHours;
        $this->data['totalDonations'] = $totalDonations;
        $this->data['totalSuggestions'] = $totalSuggestions;
        $this->data['roleLabel'] = User::getRoleLabel($user['role'] ?? '');

        $this->render('history/index');
    }

    /**
     * User Profile Page with Rank & Badge System
     */
    public function profile(): void
    {
        AuthMiddleware::handle();

        $userId = Session::getUserId();
        $userModel = new User();
        $eventModel = new \App\Models\Event();

        $user = $userModel->getById($userId);
        $events = $eventModel->getUserEvents($userId);
        $donations = $eventModel->getUserDonations($userId);

        $totalEvents = count($events);
        $totalDonations = array_reduce($donations, function ($carry, $item) {
            return $carry + ($item['amount'] ?? 0);
        }, 0);

        // Rank Logic
        $rankInfo = $this->calculateRank($totalEvents);

        // Rank Standing
        $standingPercent = max(1, 100 - ($totalEvents * 9));
        if ($totalEvents == 0)
            $standingPercent = 100;

        $this->data['title'] = 'User Profile - PIC Social Activity';
        $this->data['user'] = $user;
        $this->data['totalEvents'] = $totalEvents;
        $this->data['totalDonations'] = $totalDonations;
        $this->data['rankInfo'] = $rankInfo;
        $this->data['standingPercent'] = $standingPercent;

        $this->render('profile/index');
    }

    private function calculateRank(int $totalEvents): array
    {
        $eventsCount = min(10, $totalEvents);

        if ($eventsCount >= 9) {
            return [
                'name' => 'Diamond',
                'color' => 'cyan',
                'gradient' => 'from-cyan-400 to-blue-600',
                'border' => 'border-cyan-400',
                'glow' => 'shadow-cyan-400/50',
                'text' => 'text-cyan-400',
                'blob' => 'bg-cyan-500',
                'next_threshold' => 10,
                'progress' => 100,
                'message' => 'You reached the highest rank!'
            ];
        } elseif ($eventsCount >= 7) {
            return [
                'name' => 'Ascendant',
                'color' => 'purple',
                'gradient' => 'from-purple-400 to-indigo-600',
                'border' => 'border-purple-400',
                'glow' => 'shadow-purple-400/50',
                'text' => 'text-purple-400',
                'blob' => 'bg-purple-500',
                'next_threshold' => 9,
                'progress' => (($eventsCount - 7) / 2) * 100,
                'message' => 'Only ' . (9 - $eventsCount) . ' more event(s) until you reach Diamond!'
            ];
        } elseif ($eventsCount >= 5) {
            return [
                'name' => 'Gold',
                'color' => 'yellow',
                'gradient' => 'from-yellow-400 to-orange-500',
                'border' => 'border-yellow-400',
                'glow' => 'shadow-yellow-400/50',
                'text' => 'text-yellow-400',
                'blob' => 'bg-yellow-500',
                'next_threshold' => 7,
                'progress' => (($eventsCount - 5) / 2) * 100,
                'message' => 'Only ' . (7 - $eventsCount) . ' more event(s) until you reach Ascendant!'
            ];
        } elseif ($eventsCount >= 3) {
            return [
                'name' => 'Silver',
                'color' => 'gray',
                'gradient' => 'from-gray-300 to-gray-500',
                'border' => 'border-gray-300',
                'glow' => 'shadow-gray-400/50',
                'text' => 'text-gray-300',
                'blob' => 'bg-gray-500',
                'next_threshold' => 5,
                'progress' => (($eventsCount - 3) / 2) * 100,
                'message' => 'Only ' . (5 - $eventsCount) . ' more event(s) until you reach Gold!'
            ];
        } elseif ($eventsCount >= 1) {
            return [
                'name' => 'Bronze',
                'color' => 'orange',
                'gradient' => 'from-orange-400 to-red-500',
                'border' => 'border-orange-400',
                'glow' => 'shadow-orange-400/50',
                'text' => 'text-orange-400',
                'blob' => 'bg-orange-500',
                'next_threshold' => 3,
                'progress' => (($eventsCount - 1) / 2) * 100,
                'message' => 'Only ' . (3 - $eventsCount) . ' more event(s) until you reach Silver!'
            ];
        } else {
            return [
                'name' => 'Unranked',
                'color' => 'slate',
                'gradient' => 'from-slate-400 to-slate-600',
                'border' => 'border-slate-400',
                'glow' => 'shadow-slate-400/50',
                'text' => 'text-slate-400',
                'blob' => 'bg-slate-500',
                'next_threshold' => 1,
                'progress' => 0,
                'message' => 'Join your first event to reach Bronze rank!'
            ];
        }
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

