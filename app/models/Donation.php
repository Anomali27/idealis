<?php
/**
 * Donation Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;

class Donation
{
    private Database $db;
    private string $table = 'donations';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all donations
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT 
                    d.*,
                    u.name as donor_name,
                    u.email as donor_email,
                    a.title as activity_title
                FROM {$this->table} d
                LEFT JOIN users u ON d.user_id = u.id
                LEFT JOIN activities a ON d.activity_id = a.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['activity_id'])) {
            $sql .= " AND d.activity_id = ?";
            $params[] = $filters['activity_id'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND d.user_id = ?";
            $params[] = $filters['user_id'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND d.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['payment_method'])) {
            $sql .= " AND d.payment_method = ?";
            $params[] = $filters['payment_method'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR d.donor_name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY d.donated_at DESC";

        return $this->db->query($sql, $params);
    }

    /**
     * Get donation by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT 
                    d.*,
                    u.name as donor_name,
                    u.email as donor_email,
                    a.title as activity_title
                FROM {$this->table} d
                LEFT JOIN users u ON d.user_id = u.id
                LEFT JOIN activities a ON d.activity_id = a.id
                WHERE d.id = ?";

        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Get donations by activity
     */
    public function getByActivity(int $activityId): array
    {
        $sql = "SELECT 
                    d.*,
                    u.name as donor_name,
                    u.email as donor_email
                FROM {$this->table} d
                LEFT JOIN users u ON d.user_id = u.id
                WHERE d.activity_id = ? AND d.status = 'verified'
                ORDER BY d.donated_at DESC";

        return $this->db->query($sql, [$activityId]);
    }

    /**
     * Get donations by user
     */
    public function getByUser(int $userId): array
    {
        $sql = "SELECT 
                    d.*,
                    a.title as activity_title
                FROM {$this->table} d
                LEFT JOIN activities a ON d.activity_id = a.id
                WHERE d.user_id = ?
                ORDER BY d.donated_at DESC";

        return $this->db->query($sql, [$userId]);
    }

    /**
     * Create donation
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} 
                (user_id, activity_id, amount, donor_name, donor_email, payment_method, payment_proof, message, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

        $params = [
            $data['user_id'] ?? null,
            $data['activity_id'] ?? null,
            $data['amount'],
            $data['donor_name'],
            $data['donor_email'] ?? null,
            $data['payment_method'],
            $data['payment_proof'] ?? null,
            $data['message'] ?? null
        ];

        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Update donation status
     */
    public function updateStatus(int $id, string $status): bool
    {
        $sql = "UPDATE {$this->table} SET status = ? WHERE id = ?";
        return $this->db->execute($sql, [$status, $id]) > 0;
    }

    /**
     * Confirm donation (verify)
     */
    public function confirm(int $id): bool
    {
        return $this->updateStatus($id, 'verified');
    }

    /**
     * Reject donation
     */
    public function reject(int $id): bool
    {
        return $this->updateStatus($id, 'rejected');
    }

    /**
     * Delete donation
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Get total donations amount
     */
    public function getTotalAmount(int $activityId = null): float
    {
        if ($activityId) {
            $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM {$this->table} WHERE activity_id = ? AND status = 'verified'";
            $result = $this->db->queryOne($sql, [$activityId]);
        } else {
            $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM {$this->table} WHERE status = 'verified'";
            $result = $this->db->queryOne($sql);
        }

        return (float) ($result['total'] ?? 0);
    }

    /**
     * Get donation count
     */
    public function getCount(int $activityId = null): int
    {
        if ($activityId) {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE activity_id = ? AND status = 'verified'";
            $result = $this->db->queryOne($sql, [$activityId]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'verified'";
            $result = $this->db->queryOne($sql);
        }

        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get donations with pagination
     */
    public function getPaginated(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT 
                    d.*,
                    u.name as donor_name,
                    u.email as donor_email,
                    a.title as activity_title
                FROM {$this->table} d
                LEFT JOIN users u ON d.user_id = u.id
                LEFT JOIN activities a ON d.activity_id = a.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['activity_id'])) {
            $sql .= " AND d.activity_id = ?";
            $params[] = $filters['activity_id'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND d.status = ?";
            $params[] = $filters['status'];
        }

        $sql .= " ORDER BY d.donated_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;

        $donations = $this->db->query($sql, $params);

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} d WHERE 1=1";
        $countParams = [];

        if (!empty($filters['activity_id'])) {
            $countSql .= " AND d.activity_id = ?";
            $countParams[] = $filters['activity_id'];
        }

        if (!empty($filters['status'])) {
            $countSql .= " AND d.status = ?";
            $countParams[] = $filters['status'];
        }

        $totalResult = $this->db->queryOne($countSql, $countParams);
        $total = (int) ($totalResult['total'] ?? 0);

        return [
            'data' => $donations,
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
        $labels = [
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
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
            'pending' => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            'cancelled' => 'Cancelled'
        ];
    }

    /**
     * Get payment methods
     */
    public static function getPaymentMethods(): array
    {
        return [
            'cash' => 'Cash',
            'transfer_bca' => 'Transfer BCA',
            'transfer_bni' => 'Transfer BNI',
            'transfer_bri' => 'Transfer BRI',
            'transfer_mandiri' => 'Transfer Mandiri',
            'ewallet' => 'E-Wallet',
            'qris' => 'QRIS'
        ];
    }
}
