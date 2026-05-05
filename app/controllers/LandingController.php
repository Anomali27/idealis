<?php
/**
 * Landing Controller
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Controllers;

use App\Core\Controller;

class LandingController extends Controller
{
    /**
     * Show landing page
     */
    public function index(): void
    {
        // Get upcoming activities
        $activities = $this->getUpcomingActivities();
        
        // Get statistics
        $stats = $this->getStatistics();

        $this->data['title'] = 'Home - PIC Social Activity';
        $this->data['activities'] = $activities;
        $this->data['stats'] = $stats;

        $this->render('landing/index');
    }

    /**
     * Get upcoming activities
     */
    private function getUpcomingActivities(): array
    {
        $sql = "SELECT 
                    a.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM volunteers WHERE activity_id = a.id) as volunteer_count
                FROM activities a
                LEFT JOIN users u ON a.created_by = u.id
                WHERE a.status = 'upcoming' AND a.activity_date >= CURDATE()
                ORDER BY a.activity_date ASC
                LIMIT 6";

        return $this->db->query($sql);
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
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM activities");
        $stats['total_events'] = $result['total'] ?? 0;

        // Total volunteer hours (estimated: completed volunteers * 2 hours)
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM volunteers WHERE status = 'completed'");
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
