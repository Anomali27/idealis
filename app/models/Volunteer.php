<?php
/**
 * Volunteer / Event Participant Model (Updated to match modern events/event_participants schema)
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;
use PDOException;

class Volunteer
{
    private Database $db;
    private string $table = 'event_participants';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all volunteer registrations
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT 
                    ep.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class,
                    e.name as event_name,
                    e.date as event_date
                FROM {$this->table} ep
                JOIN users u ON ep.user_id = u.id
                JOIN events e ON ep.event_id = e.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['event_id'])) {
            $sql .= " AND ep.event_id = ?";
            $params[] = $filters['event_id'];
        }

        if (!empty($filters['activity_id'])) { // legacy fallback
            $sql .= " AND ep.event_id = ?";
            $params[] = $filters['activity_id'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND ep.user_id = ?";
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.nis LIKE ? OR e.name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY ep.created_at DESC";

        return $this->db->query($sql, $params);
    }

    /**
     * Get volunteer registration by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT 
                    ep.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class,
                    e.name as event_name,
                    e.date as event_date
                FROM {$this->table} ep
                JOIN users u ON ep.user_id = u.id
                JOIN events e ON ep.event_id = e.id
                WHERE ep.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Get volunteers by event (activity) ID
     */
    public function getByActivity(int $eventId): array
    {
        $sql = "SELECT 
                    ep.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class
                FROM {$this->table} ep
                JOIN users u ON ep.user_id = u.id
                WHERE ep.event_id = ?
                ORDER BY ep.created_at DESC";

        return $this->db->query($sql, [$eventId]);
    }

    /**
     * Get volunteers by user
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
                    ep.*,
                    e.name as event_name,
                    e.date as event_date,
                    e.description as event_description
                FROM {$this->table} ep
                JOIN events e ON ep.event_id = e.id
                WHERE ep.user_id = ?
                ORDER BY e.date DESC";

        return $this->db->query($sql, [$userId]);
    }

    /**
     * Check if user is registered for event
     */
    public function isRegistered(int $eventId, int $userId): bool
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE event_id = ? AND user_id = ?";
        
        $result = $this->db->queryOne($sql, [$eventId, $userId]);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Register volunteer
     */
    public function register(int $userId, int $eventId, string $notes = ''): int
    {
        if ($this->isRegistered($eventId, $userId)) {
            throw new \Exception('You are already registered for this event.');
        }

        $sql = "INSERT INTO {$this->table} (user_id, event_id, created_at) VALUES (?, ?, NOW())";
        $this->db->execute($sql, [$userId, $eventId]);
        
        return $this->db->lastInsertId();
    }

    /**
     * Update volunteer status (Legacy noop wrapper for event_participants without status column)
     */
    public function updateStatus(int $id, string $status): bool
    {
        return true;
    }

    /**
     * Cancel volunteer registration (delete record)
     */
    public function cancel(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Confirm volunteer (noop for compatibility)
     */
    public function confirm(int $id): bool
    {
        return true;
    }

    /**
     * Complete volunteer (noop for compatibility)
     */
    public function complete(int $id): bool
    {
        return true;
    }

    /**
     * Reject volunteer (delete record)
     */
    public function reject(int $id): bool
    {
        return $this->delete($id);
    }

    /**
     * Delete volunteer registration
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Get volunteer count by event (activity)
     */
    public function getCountByActivity(int $eventId): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE event_id = ?";
        $result = $this->db->queryOne($sql, [$eventId]);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get volunteer count by user
     */
    public function getCountByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ?";
        $result = $this->db->queryOne($sql, [$userId]);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get user's volunteer history
     */
    public function getHistory(int $userId): array
    {
        $sql = "SELECT 
                    ep.id,
                    'registered' as volunteer_status,
                    ep.created_at as registered_at,
                    e.id as activity_id,
                    e.name as activity_title,
                    e.date as activity_date,
                    'Online' as location,
                    'upcoming' as activity_status
                FROM {$this->table} ep
                JOIN events e ON ep.event_id = e.id
                WHERE ep.user_id = ?
                ORDER BY e.date DESC";

        return $this->db->query($sql, [$userId]);
    }

    /**
     * Get volunteers with pagination
     */
    public function getPaginated(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT 
                    ep.*,
                    u.name as user_name,
                    u.email as user_email,
                    u.nis,
                    u.class,
                    e.name as event_name,
                    e.date as event_date
                FROM {$this->table} ep
                JOIN users u ON ep.user_id = u.id
                JOIN events e ON ep.event_id = e.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['event_id'])) {
            $sql .= " AND ep.event_id = ?";
            $params[] = $filters['event_id'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.nis LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY ep.created_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;

        $volunteersList = $this->db->query($sql, $params);

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} ep WHERE 1=1";
        $countParams = [];

        if (!empty($filters['event_id'])) {
            $countSql .= " AND ep.event_id = ?";
            $countParams[] = $filters['event_id'];
        }

        $totalResult = $this->db->queryOne($countSql, $countParams);
        $total = (int) ($totalResult['total'] ?? 0);

        return [
            'data' => $volunteersList,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    /**
     * Get status label
     */
    public static function getStatusLabel(string $status): string
    {
        return 'Registered';
    }

    /**
     * Get all statuses
     */
    public static function getStatuses(): array
    {
        return [
            'registered' => 'Registered'
        ];
    }
}
