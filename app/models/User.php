<?php
/**
 * User Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;
use PDOException;
use Exception;

class User
{
    private Database $db;
    private string $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all users
     */
    public function getAll(array $filters = []): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($filters['role'])) {
            $sql .= " AND role = ?";
            $params[] = $filters['role'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR email LIKE ? OR nis LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($filters['is_active'])) {
            $sql .= " AND is_active = 1";
        }

        $sql .= " ORDER BY created_at DESC";

        return $this->db->query($sql, $params);
    }

    /**
     * Get user by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->queryOne($sql, [$id]);
    }

    /**
     * Get user by email
     */
    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        return $this->db->queryOne($sql, [$email]);
    }

    /**
     * Get user by NIS
     */
    public function getByNis(string $nis): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE nis = ?";
        return $this->db->queryOne($sql, [$nis]);
    }

    /**
     * Create new user
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} 
                (name, email, password, role, nis, class, phone, avatar, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $params = [
            $data['name'],
            $data['email'],
            $data['password'], // Should be hashed
            $data['role'] ?? 'student',
            $data['nis'] ?? null,
            $data['class'] ?? null,
            $data['phone'] ?? null,
            $data['avatar'] ?? 'default.png',
            $data['is_active'] ?? 1
        ];

        $this->db->execute($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * Update user
     */
    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'email', 'role', 'nis', 'class', 'phone', 'avatar', 'is_active'])) {
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
     * Update password
     */
    public function updatePassword(int $id, string $newPassword): bool
    {
        $sql = "UPDATE {$this->table} SET password = ? WHERE id = ?";
        return $this->db->execute($sql, [$newPassword, $id]) > 0;
    }

    /**
     * Delete user (soft delete - set is_active = 0)
     */
    public function delete(int $id): bool
    {
        return $this->update($id, ['is_active' => 0]);
    }

    /**
     * Hard delete user
     */
    public function hardDelete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]) > 0;
    }

    /**
     * Verify user credentials
     */
    public function verifyCredentials(string $email, string $password): ?array
    {
        $user = $this->getByEmail($email);

        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user['password'])) {
            return null;
        }

        if (!$user['is_active']) {
            return null;
        }

        // Remove password from user data
        unset($user['password']);

        return $user;
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email, int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $result = $this->db->queryOne($sql, $params);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Check if NIS exists
     */
    public function nisExists(string $nis, int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE nis = ?";
        $params = [$nis];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $result = $this->db->queryOne($sql, $params);
        return ($result['count'] ?? 0) > 0;
    }

    /**
     * Get users by role
     */
    public function getByRole(string $role): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE role = ? ORDER BY name";
        return $this->db->query($sql, [$role]);
    }

    /**
     * Get active users count
     */
    public function getActiveCount(): int
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE is_active = 1";
        $result = $this->db->queryOne($sql);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Get users with pagination
     */
    public function getPaginated(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        if (!empty($filters['role'])) {
            $sql .= " AND role = ?";
            $params[] = $filters['role'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (name LIKE ? OR email LIKE ? OR nis LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $sql .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $params[] = $perPage;
        $params[] = $offset;

        $users = $this->db->query($sql, $params);

        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$this->table} WHERE 1=1";
        $countParams = [];

        if (!empty($filters['role'])) {
            $countSql .= " AND role = ?";
            $countParams[] = $filters['role'];
        }

        if (!empty($filters['search'])) {
            $countSql .= " AND (name LIKE ? OR email LIKE ? OR nis LIKE ?)";
            $search = "%{$filters['search']}%";
            $countParams[] = $search;
            $countParams[] = $search;
            $countParams[] = $search;
        }

        $totalResult = $this->db->queryOne($countSql, $countParams);
        $total = (int) ($totalResult['total'] ?? 0);

        return [
            'data' => $users,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }

    /**
     * Hash password
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verify password
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Get role label
     */
    public static function getRoleLabel(string $role): string
    {
        $labels = [
            'admin' => 'Administrator',
            'committee' => 'Panitia/Osis',
            'student' => 'Siswa',
            'teacher' => 'Guru'
        ];

        return $labels[$role] ?? ucfirst($role);
    }

    /**
     * Get all roles
     */
    public static function getRoles(): array
    {
        return [
            'admin' => 'Administrator',
            'committee' => 'Panitia/Osis',
            'student' => 'Siswa',
            'teacher' => 'Guru'
        ];
    }
}
