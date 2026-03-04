<?php
/**
 * Database Connection Class (PDO)
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Core;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static $instance = null;
    private $connection;
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;

    /**
     * Constructor - Load config and establish connection
     */
    private function __construct()
    {
        // Load database configuration
        require_once dirname(__DIR__) . '/config/Database.php';

        $this->host = DB_HOST;
        $this->dbname = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->charset = DB_CHARSET;

        $this->connect();
    }

    /**
     * Get singleton instance (Database Connection)
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Establish PDO connection
     */
    private function connect(): void
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $this->host,
            $this->dbname,
            $this->charset
        );

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => false,
        ];

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->handleError('Database Connection Failed', $e);
        }
    }

    /**
     * Get PDO connection
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Execute a query with parameters (Prepared Statement)
     */
    public function query(string $sql, array $params = []): array
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->handleError('Query Failed', $e);
            return [];
        }
    }

    /**
     * Execute a query and return single row
     */
    public function queryOne(string $sql, array $params = []): ?array
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            $this->handleError('Query Failed', $e);
            return null;
        }
    }

    /**
     * Execute insert/update/delete query
     */
    public function execute(string $sql, array $params = []): int
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->handleError('Execute Failed', $e);
            return 0;
        }
    }

    /**
     * Get last inserted ID
     */
    public function lastInsertId(): int
    {
        return (int) $this->connection->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit(): void
    {
        $this->connection->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollBack(): void
    {
        $this->connection->rollBack();
    }

    /**
     * Handle database errors
     */
private function handleError(string $message, PDOException $e): void
    {
        $debug = defined('DEBUG_MODE') ? DEBUG_MODE : true;
        if ($debug) {
            throw new Exception($message . ': ' . $e->getMessage());
        } else {
            error_log($message . ': ' . $e->getMessage());
            die('An error occurred. Please try again later.');
        }
    }

    /**
     * Prevent cloning (Singleton pattern)
     */
    private function __clone() {}

    /**
     * Prevent unserialization (Singleton pattern)
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
