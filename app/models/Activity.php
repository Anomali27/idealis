<?php
/**
 * Activity Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;
use PDOException;

class Activity
{
    private Database $db;
    private string $table = 'activities';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all activities
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT 
                    a.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM volunteers WHERE activity_id = a.id) as volunteer_count
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (a.title LIKE ? OR a.description LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND a.activity_date >= ?";
            $params[] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND a.activity_date <= ?";
            $params[] = $filters['date_to'];
        }

        $sql .= " ORDER BY a.activity_date ASC";

        return $this->db->query($sql, $params);
    }

    /**
     * Get upcoming activities
     */
    public function getUpcoming(int $limit = 6): array
    {
        $sql = "SELECT 
                    a.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM volunteers WHERE activity_id = a.id) as volunteer_count
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id
                WHERE a.status = 'upcoming' AND a.activity_date >= CURDATE()
                ORDER BY a.activity_date ASC
                LIMIT ?";

        return $this->db->query($sql, [$limit]);
    }

    /**
     * Get activity by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT 
                    a.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM volunteers WHERE activity_id = a.id) as volunteer_count
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id
                WHERE a.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Get activity by ID with creator info
     */
    public function getByIdWithCreator(int $id): ?array
    {
        $sql = "SELECT 
                    a.*,
                    u.name as creator_name,
                    u.email as creator_email
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id
                WHERE a.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Create new activity
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} 
                (title, description, activity_date, activity_time, location, max_volunteers, status, cover_image, requirements, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $data['title'],
            $data['description'] ?? null,
            $data['activity_date'],
            $data['activity_time'],
            $data['location'],
            $data['max_volunteers'] ?? 0,
            $data['status'] ?? 'draft',
            $data['cover_image'] ?? null,
            $data['requirements'] ?? null,
            $data['created_by'] ?? null
        ];

        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Update activity
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        $allowedFields = [
            'title', 'description', 'activity_date', 'activity_time', 
            'location', 'max_volunteers', 'status', 'cover_image', 'requirements'
        ];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $fields[] = "{$key} = ?";
                $params[] = $value;
            }
        }

        if (empty($fields)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";

        return $this->db->execute($sql, $params) > 0;
    }

    /**
     * Update volunteer count
     */
    public function updateVolunteerCount(int $id): bool
    {
        $sql = "UPDATE {$this->table} 
                SET current_volunteers = (
                    SELECT COUNT(*) FROM volunteers 
                    WHERE activity_id = ? AND status IN ('registered', 'confirmed', 'completed')
                )
                WHERE id = ?";
        
        return $this->db->execute($sql, [$id, $id]) > 0;
    }

    /**
     * Delete activity (soft delete)
     */
    public function delete(int $id): bool
    {
        return $this->update($id, ['status' => 'cancelled']);
    }

    /**
     * Hard delete activity
     */
    public function hardDelete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Get activities by creator
     */
    public function getByCreator(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE created_by = ? ORDER BY activity_date DESC";
        return $this->db->query($sql, [$userId]);
    }

    /**
     * Get activities with pagination
     */
    public function getPaginated(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT 
                    a.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM volunteers WHERE activity_id = a.id) as volunteer_count
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (a.title LIKE ? OR a.description LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY a.activity_date ASC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;

        $activities = $this->db->query($sql, $params);

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $countParams = [];

        if (!empty($filters['status'])) {
            $countSql .= " AND status = ?";
            $countParams[] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $countSql .= " AND (title LIKE ? OR description LIKE ?)";
            $search = "%{$filters['search']}%";
            $countParams[] = $search;
            $countParams[] = $search;
        }

        $totalResult = $this->db->queryOne($countSql, $countParams);
        $total = (int) ($totalResult['total'] ?? 0);

        return [
            'data' => $activities,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    /**
     * Get activity statistics
     */
    public function getStats(): array
    {
        $stats = [];

        // Total activities
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM {$this->table}");
        $stats['total'] = $result['total'] ?? 0;

        // Upcoming
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'upcoming'");
        $stats['upcoming'] = $result['total'] ?? 0;

        // Ongoing
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'ongoing'");
        $stats['ongoing'] = $result['total'] ?? 0;

        // Completed
        $result = $this->db->queryOne("SELECT COUNT(*) as total FROM {$this->table} WHERE status = 'completed'");
        $stats['completed'] = $result['total'] ?? 0;

        // Total volunteers
        $result = $this->db->queryOne("SELECT COALESCE(SUM(current_volunteers), 0) as total FROM {$this->table}");
        $stats['total_volunteers'] = $result['total'] ?? 0;

        return $stats;
    }

    /**
     * Check if user is registered for activity
     */
    public function isUserRegistered(int $activityId, int $userId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM volunteers 
                WHERE activity_id = ? AND user_id = ? 
                AND status NOT IN ('cancelled', 'rejected')";
        
        $result = $this->db->queryOne($sql, [$activityId, $userId]);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Get status label
     */
    public static function getStatusLabel(string $status): string
    {
        $labels = [
            'draft' => 'Draft',
            'upcoming' => 'Upcoming',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        return $labels[$status] ?? ucfirst($status);
    }

    /**
     * Get all statuses
     */
    public static function getStatuses(): array
    {
        return [
            'draft' => 'Draft',
            'upcoming' => 'Upcoming',
            'ongoing' => 'Ongoing',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
    }

    /**
     * Update activity status based on date
     */
    public function updateStatusByDate(): void
    {
        // Update upcoming to ongoing
        $sql = "UPDATE {$this->table} 
                SET status = 'ongoing' 
                WHERE status = 'upcoming' AND activity_date = CURDATE()";
        $this->db->execute($sql);

        // Update ongoing to completed
        $sql = "UPDATE {$this->table} 
                SET status = 'completed' 
                WHERE status = 'ongoing' AND activity_date < CURDATE()";
        $this->db->execute($sql);
    }
}
