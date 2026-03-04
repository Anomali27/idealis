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

        // Total activities
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM activities WHERE status = 'completed'");
        $stats['total_activities'] = $result['total'] ?? 0;

        // Total volunteers
        $result = $this->db->queryOne("SELECT COUNT(DISTINCT user_id) as total FROM volunteers");
        $stats['total_volunteers'] = $result['total'] ?? 0;

        // Total donations
        $result = $this->db->queryOne("SELECT COALESCE(SUM(amount), 0) as total FROM donations WHERE status = 'verified'");
        $stats['total_donations'] = $result['total'] ?? 0;

        // Upcoming activities
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM activities WHERE status = 'upcoming'");
        $stats['upcoming_activities'] = $result['total'] ?? 0;

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
