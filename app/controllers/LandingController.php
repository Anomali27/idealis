<?php
/**
 * Landing Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Models\News;

class LandingController extends Controller
{
    /**
     * Show landing page
     */
    public function index(): void
    {
        // Get statistics
        $stats = $this->getStatistics();

        // Get latest news
        $newsModel = new News();
        $news = $newsModel->getLatest(4);

        $this->data['title'] = 'Home - PIC Social Activity';
        $this->data['stats'] = $stats;
        $this->data['news'] = $news;

        $this->render('landing/index');
    }

    /**
     * Get statistics for landing page
     */
    private function getStatistics(): array
    {
        $stats = [];

        // Total students
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
        $stats['total_students'] = $result['total'] ?? 0;

        // Total teachers
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM users WHERE role = 'teacher'");
        $stats['total_teachers'] = $result['total'] ?? 0;

        // Total events
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM events");
        $stats['total_events'] = $result['total'] ?? 0;

        // Total volunteer hours (estimated: total participants * 2 hours)
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM event_participants");
        $stats['total_hours'] = ($result['total'] ?? 0) * 2;

        return $stats;
    }

    /**
     * Show about page
     */
    public function about(): void
    {
        $this->data['title'] = 'About - PIC Social Activity';
        $this->render('landing/about');
    }

    /**
     * Show contact page
     */
    public function contact(): void
    {
        $this->data['title'] = 'Contact - PIC Social Activity';
        $this->render('landing/contact');
    }
}
