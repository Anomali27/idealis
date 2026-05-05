<?php
/**
 * News Model
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Models;

use App\Core\Database;

class News
{
    private Database $db;
    private string $table = 'news';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get latest news
     */
    public function getLatest(int $limit = 4): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY date DESC LIMIT ?";
        return $this->db->query($sql, [$limit]);
    }

    /**
     * Get news by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->queryOne($sql, [$id]);
    }
}
