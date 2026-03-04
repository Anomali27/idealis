<?php
/**
 * Database Configuration for PIC Social Activity & Volunteer Management System
 * Pontianak International College
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'pic_volunteer_system');
define('DB_USER', 'root');
define('DB_PASS', ''); // Default Laragon user
define('DB_CHARSET', 'utf8mb4');

// Development Mode (true = show errors, false = hide errors)
define('DEBUG_MODE', true);

// Display errors based on debug mode
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

/**
 * Get database DSN (Data Source Name)
 */
function getDSN(): string
{
    return sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );
}

/**
 * Get database connection options
 */
function getDBOptions(): array
{
    return [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => false,
    ];
}
