<?php
/**
 * Volunteer Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;
use PDOException;

class Volunteer
{
    private Database $db;
    private string $table = 'volunteers';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all volunteers
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT 
                    v.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class,
                    a.title as activity_title,
                    a.activity_date,
                    a.location
                FROM {$this->table} v
                JOIN users u ON v.user_id = u.id
                JOIN activities a ON v.activity_id = a.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['activity_id'])) {
            $sql .= " AND v.activity_id = ?";
            $params[] = $filters['activity_id'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND v.user_id = ?";
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND v.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.nis LIKE ? OR a.title LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY v.registered_at DESC";

        return $this->db->query($sql, $params);
    }

    /**
     * Get volunteer by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT 
                    v.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class,
                    a.title as activity_title,
                    a.activity_date,
                    a.location
                FROM {$this->table} v
                JOIN users u ON v.user_id = u.id
                JOIN activities a ON v.activity_id = a.id
                WHERE v.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Get volunteers by activity
     */
    public function getByActivity(int $activityId): array
    {
        $sql = "SELECT 
                    v.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class
                FROM {$this->table} v
                JOIN users u ON v.user_id = u.id
                WHERE v.activity_id = ?
                ORDER BY v.registered_at DESC";

        return $this->db->query($sql, [$activityId]);
    }

    /**
     * Get volunteers by user (alias for getByUserId)
     */
    public function getByUser(int $userId): array
    {
        return $this->getByUserId($userId);
    }

    /**
     * Get volunteers by user ID
     */
    public function getByUserId(int $userId): array
    {
        $sql = "SELECT 
                    v.*,
                    a.title as activity_title,
                    a.activity_date,
                    a.location,
                    a.status as activity_status
                FROM {$this->table} v
                JOIN activities a ON v.activity_id = a.id
                WHERE v.user_id = ?
                ORDER BY a.activity_date DESC";

        return $this->db->query($sql, [$userId]);
    }

    /**
     * Check if user is registered for activity
     */
    public function isRegistered(int $activityId, int $userId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE activity_id = ? AND user_id = ? 
                AND status NOT IN ('cancelled', 'rejected')";
        
        $result = $this->db->queryOne($sql, [$activityId, $userId]);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Register volunteer
     */
    public function register(int $userId, int $activityId, string $notes = ''): int
    {
        // Check if already registered
        if ($this->isRegistered($activityId, $userId)) {
            throw new \Exception('You are already registered for this activity.');
        }

        $sql = "INSERT INTO {$this->table} (user_id, activity_id, status, notes) 
                VALUES (?, ?, 'registered', ?)";

        $this->db->execute($sql, [$userId, $activityId, $notes]);
        
        // Update activity volunteer count
        $this->updateActivityVolunteerCount($activityId);
        
        return $this->db->lastInsertId();
    }

    /**
     * Update volunteer status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        $result = $this->db->execute($sql, [$status, $id]);
        
        // Get activity_id and update count
        $volunteer = $this->getById($id);
        if ($volunteer) {
            $this->updateActivityVolunteerCount($volunteer['activity_id']);
        }
        
        return $result > 0;
    }

    /**
     * Cancel volunteer registration
     */
    public function cancel(int $id): bool
    {
        return $this->updateStatus($id, 'cancelled');
    }

    /**
     * Confirm volunteer
     */
    public function confirm(int $id): bool
    {
        return $this->updateStatus($id, 'confirmed');
    }

    /**
     * Complete volunteer
     */
    public function complete(int $id): bool
    {
        return $this->updateStatus($id, 'completed');
    }

    /**
     * Reject volunteer
     */
    public function reject(int $id): bool
    {
        return $this->updateStatus($id, 'rejected');
    }

    /**
     * Delete volunteer record
     */
    public function delete(int $id): bool
    {
        // Get activity_id before delete
        $volunteer = $this->getById($id);
        
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $result = $this->db->execute($sql, [$id]);
        
        // Update activity volunteer count
        if ($volunteer) {
            $this->updateActivityVolunteerCount($volunteer['activity_id']);
        }
        
        return $result > 0;
    }

    /**
     * Get volunteer count by activity
     */
    public function getCountByActivity(int $activityId): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE activity_id = ? AND status NOT IN ('cancelled', 'rejected')";
        
        $result = $this->db->queryOne($sql, [$activityId]);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get volunteer count by user
     */
    public function getCountByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE user_id = ? AND status = 'completed'";
        
        $result = $this->db->queryOne($sql, [$userId]);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get user's volunteer history
     */
    public function getHistory(int $userId): array
    {
        $sql = "SELECT 
                    v.id,
                    v.status as volunteer_status,
                    v.registered_at,
                    a.id as activity_id,
                    a.title as activity_title,
                    a.activity_date,
                    a.location,
                    a.status as activity_status
                FROM {$this->table} v
                JOIN activities a ON v.activity_id = a.id
                WHERE v.user_id = ?
                ORDER BY a.activity_date DESC";

        return $this->db->query($sql, [$userId]);
    }

    /**
     * Get volunteers with pagination
     */
    public function getPaginated(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT 
                    v.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class,
                    a.title as activity_title,
                    a.activity_date
                FROM {$this->table} v
                JOIN users u ON v.user_id = u.id
                JOIN activities a ON v.activity_id = a.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['activity_id'])) {
            $sql .= " AND v.activity_id = ?";
            $params[] = $filters['activity_id'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND v.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.nis LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY v.registered_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;

        $volunteers = $this->db->query($sql, $params);

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} v WHERE 1=1";
        $countParams = [];

        if (!empty($filters['activity_id'])) {
            $countSql .= " AND v.activity_id = ?";
            $countParams[] = $filters['activity_id'];
        }

        if (!empty($filters['status'])) {
            $countSql .= " AND v.status = ?";
            $countParams[] = $filters['status'];
        }

        $totalResult = $this->db->queryOne($countSql, $countParams);
        $total = (int) ($totalResult['total'] ?? 0);

        return [
            'data' => $volunteers,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    /**
     * Update activity volunteer count
     */
    private function updateActivityVolunteerCount(int $activityId): void
    {
        $sql = "UPDATE activities 
                SET current_volunteers = (
                    SELECT COUNT(*) FROM {$this->table} 
                    WHERE activity_id = ? AND status NOT IN ('cancelled', 'rejected')
                )
                WHERE id = ?";
        
        $this->db->execute($sql, [$activityId, $activityId]);
    }

    /**
     * Get status label
     */
    public static function getStatusLabel(string $status): string
    {
        $labels = [
            'registered' => 'Registered',
            'confirmed' => 'Confirmed',
            'attended' => 'Attended',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rejected' => 'Rejected'
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    /**
     * Get all statuses
     */
    public static function getStatuses(): array
    {
        return [
            'registered' => 'Registered',
            'confirmed' => 'Confirmed',
            'attended' => 'Attended',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rejected' => 'Rejected'
        ];
    }
}
