<?php
/**
 * Event Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;

class Event
{
    private Database $db;
    private string $table = 'events';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all events with computed donation and participant data
     */
    public function getAll(int $limit = 10): array
    {
        $sql = "SELECT 
                    e.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM event_participants WHERE event_id = e.id) as participant_count,
                    (SELECT COALESCE(SUM(amount), 0) FROM event_donations WHERE event_id = e.id) as total_donation
                FROM {$this->table} e
                LEFT JOIN users u ON e.created_by = u.id
                ORDER BY e.date DESC
                LIMIT ?";

        return $this->db->query($sql, [$limit]);
    }

    /* Get event by ID with full details */
    public function getById(int $id): ?array
    {
        $sql = "SELECT 
                    e.*,
                    u.name as creator_name,
                    (SELECT COUNT(*) FROM event_participants WHERE event_id = e.id) as participant_count,
                    (SELECT COALESCE(SUM(amount), 0) FROM event_donations WHERE event_id = e.id) as total_donation
                FROM {$this->table} e
                LEFT JOIN users u ON e.created_by = u.id
                WHERE e.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /* Get top donors for an event (computed dynamically)*/
    public function getTopDonors(int $eventId, int $limit = 5): array
    {
        $sql = "SELECT donor_name, donor_class, amount, message
                FROM event_donations
                WHERE event_id = ?
                ORDER BY amount DESC
                LIMIT ?";

        return $this->db->query($sql, [$eventId, $limit]);
    }

    /* Get participants and their donations for an event */
    public function getParticipants(int $eventId): array
    {
        $sql = "SELECT u.id, u.name, u.email, u.class, u.major, p.created_at as joined_at,
                       (SELECT COALESCE(SUM(amount), 0) FROM event_donations ed WHERE ed.event_id = p.event_id AND ed.user_id = u.id) as donation_amount
                FROM event_participants p
                JOIN users u ON p.user_id = u.id
                WHERE p.event_id = ?
                ORDER BY p.created_at DESC";

        return $this->db->query($sql, [$eventId]);
    }

    /* Check if a user is a participant*/
    public function isParticipant(int $eventId, int $userId): bool
    {
        $sql = "SELECT 1 FROM event_participants WHERE event_id = ? AND user_id = ?";
        $result = $this->db->queryOne($sql, [$eventId, $userId]);
        return !empty($result);
    }

    /* Add a participant */
    public function addParticipant(int $eventId, int $userId): bool
    {
        try {
            $sql = "INSERT IGNORE INTO event_participants (event_id, user_id) VALUES (?, ?)";
            return $this->db->execute($sql, [$eventId, $userId]) > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /* Create new event */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} 
                (name, image_url, date, description, target_donation, created_by) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $params = [
            $data['name'],
            $data['image_url'] ?? null,
            $data['date'],
            $data['description'] ?? null,
            $data['target_donation'] ?? null,
            $data['created_by'] ?? null
        ];

        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /* Update event */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        $allowedFields = [
            'name', 'image_url', 'date', 'description', 'target_donation'
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
     * Delete event
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Add donation to event
     */
    public function addDonation(array $data): int
    {
        $sql = "INSERT INTO event_donations (event_id, user_id, donor_name, donor_class, amount, message)
                VALUES (?, ?, ?, ?, ?, ?)";

        $params = [
            $data['event_id'],
            $data['user_id'] ?? null,
            $data['donor_name'],
            $data['donor_class'] ?? null,
            $data['amount'],
            $data['message'] ?? null
        ];

        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Get all donations for an event
     */
    public function getDonations(int $eventId): array
    {
        $sql = "SELECT * FROM event_donations WHERE event_id = ? ORDER BY amount DESC";
        return $this->db->query($sql, [$eventId]);
    }

    /**
     * Get events user has joined
     */
    public function getUserEvents(int $userId): array
    {
        $sql = "SELECT e.*, p.created_at as joined_at 
                FROM event_participants p
                JOIN {$this->table} e ON p.event_id = e.id
                WHERE p.user_id = ?
                ORDER BY e.date DESC";
        return $this->db->query($sql, [$userId]);
    }

    /**
     * Get user donations
     */
    public function getUserDonations(int $userId): array
    {
        $sql = "SELECT d.*, e.name as event_name 
                FROM event_donations d
                JOIN {$this->table} e ON d.event_id = e.id
                WHERE d.user_id = ?
                ORDER BY d.id DESC";
        return $this->db->query($sql, [$userId]);
    }
}
