<?php
/**
 * Student Controller
 * PIC Social Activity & Volunteer Management
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\AuthMiddleware;
use App\Models\Activity;
use App\Models\Volunteer;

class StudentController extends Controller
{
    private Activity $activityModel;
    private Volunteer $volunteerModel;

    public function __construct()
    {
        parent::__construct();
        $this->activityModel = new Activity();
        $this->volunteerModel = new Volunteer();
    }

    /**
     * Student dashboard - show student home
     */
    public function index(): void
    {
        // Get upcoming activities
        $activities = $this->activityModel->getUpcoming(6);
        
        $this->data['title'] = 'Dashboard Siswa - PIC Volunteer';
        $this->data['activities'] = $activities;
        
        $this->render('student/dashboard');
    }

    /**
     * Show student profile/details
     */
    public function show(int $id): void
    {
        AuthMiddleware::handle();
        
        $userId = Session::getUserId();
        
        // Only allow viewing own profile or admin
        if ($userId !== $id && !AuthMiddleware::isAdmin()) {
            Session::setFlash('error', 'Anda tidak dapat melihat profil pengguna lain.');
            header('Location: /student/dashboard');
            exit;
        }

        $userModel = new \App\Models\User();
        $user = $userModel->getById($id);
        
        if (!$user) {
            Session::setFlash('error', 'Pengguna tidak ditemukan.');
            header('Location: /student/dashboard');
            exit;
        }

        // Get volunteer history
        $volunteerHistory = $this->volunteerModel->getByUserId($id);
        
        $this->data['title'] = 'Profil - ' . htmlspecialchars($user['name']);
        $this->data['user'] = $user;
        $this->data['volunteerHistory'] = $volunteerHistory;
        
        $this->render('student/profile');
    }

    /**
     * Student dashboard
     */
    public function dashboard(): void
    {
        AuthMiddleware::handle();
        
        $userId = Session::getUserId();
        $userName = Session::getUserName();
        
        // Get upcoming activities
        $activities = $this->activityModel->getUpcoming(6);
        
        // Get user's volunteer history
        $myVolunteers = $this->volunteerModel->getByUserId($userId);
        
        // Get statistics
        $stats = [
            'total_activities' => count($activities),
            'my_volunteers' => count($myVolunteers),
            'completed' => count(array_filter($myVolunteers, fn($v) => $v['status'] === 'completed')),
            'upcoming' => count(array_filter($myVolunteers, fn($v) => $v['status'] === 'confirmed'))
        ];

        $this->data['title'] = 'Dashboard Siswa - PIC Volunteer';
        $this->data['userName'] = $userName;
        $this->data['activities'] = $activities;
        $this->data['myVolunteers'] = $myVolunteers;
        $this->data['stats'] = $stats;

        $this->render('student/dashboard');
    }

    /**
     * Get student's volunteer history
     */
    public function history(): void
    {
        AuthMiddleware::handle();
        
        $userId = Session::getUserId();
        $history = $this->volunteerModel->getByUserId($userId);
        
        $this->data['title'] = 'Riwayat Relawan - PIC Volunteer';
        $this->data['history'] = $history;

        $this->render('student/history');
    }
}
