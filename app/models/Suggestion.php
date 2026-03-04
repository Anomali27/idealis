<?php
/**
 * Suggestion Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;

class Suggestion
{
    private Database $db;
    private string $table = 'suggestions';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all suggestions
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT 
                    s.*,
                    u.name as user_name,
                    u.email as user_email
                FROM {$this->table} s
                LEFT JOIN users u ON s.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND s.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            $sql .= " AND s.category = ?";
            $params[] = $filters['category'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (s.title LIKE ? OR s.description LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY s.created_at DESC";

        return $this->db->query($sql, $params);
    }

    /**
     * Get suggestion by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT 
                    s.*,
                    u.name as user_name,
                    u.email as user_email
                FROM {$this->table} s
                LEFT JOIN users u ON s.user_id = u.id
                WHERE s.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Get suggestions by user
     */
    public function getByUser(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->query($sql, [$userId]);
    }

    /**
     * Create suggestion
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} 
                (user_id, title, description, category, status) 
                VALUES (?, ?, ?, ?, 'pending')";

        $params = [
            $data['user_id'] ?? null,
            $data['title'],
            $data['description'],
            $data['category'] ?? 'general'
        ];

        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Update suggestion status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        return $this->db->execute($sql, [$status, $id]) > 0;
    }

    /**
     * Add admin response
     */
    public function addResponse(int $id, string $response): bool
    {
        $sql = "UPDATE {$this->table} SET response = ?, status = 'responded' WHERE id = ?";
        return $this->db->execute($sql, [$response, $id]) > 0;
    }

    /**
     * Delete suggestion
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Get suggestion count by user
     */
    public function getCountByUser(int $userId): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE user_id = ?";
        $result = $this->db->queryOne($sql, [$userId]);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get pending suggestions count
     */
    public function getPendingCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'pending'";
        $result = $this->db->queryOne($sql);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get status label
     */
    public static function getStatusLabel(string $status): string
    {
        $labels = [
            'pending' => 'Pending',
            'responded' => 'Responded',
            'implemented' => 'Implemented',
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
            'pending' => 'Pending',
            'responded' => 'Responded',
            'implemented' => 'Implemented',
            'rejected' => 'Rejected'
        ];
    }

    /**
     * Get all categories
     */
    public static function getCategories(): array
    {
        return [
            'general' => 'General',
            'activity' => 'Activity Suggestion',
            'improvement' => 'System Improvement',
            'event' => 'Event Idea',
            'feedback' => 'Feedback',
            'other' => 'Other'
        ];
    }
}
