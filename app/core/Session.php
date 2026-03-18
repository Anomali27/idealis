<?php
/**
 * Session Management Class
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Core;

class Session
{
    /**
     * Start session if not started
     */
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Set session cookie parameters for security
            session_set_cookie_params([
                'lifetime' => 86400, // 24 hours
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    /**
     * Set session value
     */
    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value
     */
    public static function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session value
     */
    public static function remove(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Set flash message (temporary message)
     */
    public static function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Get flash message and remove it
     */
    public static function getFlash(string $type = null)
    {
        if ($type !== null) {
            $flash = $_SESSION['flash'][$type] ?? null;
            unset($_SESSION['flash'][$type]);
            return $flash;
        }

        $flash = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Check if flash message exists
     */
    public static function hasFlash(string $type): bool
    {
        return isset($_SESSION['flash'][$type]);
    }

    /**
     * Set user data after login
     */
    public static function setUser(array $user): void
    {
        self::set('user_id', $user['id']);
        self::set('user_name', $user['name']);
        self::set('user_email', $user['email']);
        self::set('user_role', $user['role']);
        self::set('user', $user);

        // Regenerate session ID for security
        self::regenerate();
    }

    /**
     * Get current user ID
     */
    public static function getUserId(): ?int
    {
        return self::get('user_id') ? (int) self::get('user_id') : null;
    }

    /**
     * Get current user name
     */
    public static function getUserName(): ?string
    {
        return self::get('user_name');
    }

    /**
     * Get current user role
     */
    public static function getUserRole(): ?string
    {
        return self::get('user_role');
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn(): bool
    {
        return self::has('user_id');
    }

    /**
     * Get full user data
     */
    public static function getUser(): ?array
    {
        return self::get('user');
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole(string $role): bool
    {
        return self::get('user_role') === $role;
    }

    /**
     * Check if user has any of the specified roles
     */
    public static function hasAnyRole(array $roles): bool
    {
        return in_array(self::get('user_role'), $roles);
    }

    /**
     * Login user
     */
    public static function login(array $user): void
    {
        self::setUser($user);
        self::set('logged_in_at', time());
    }

    /**
     * Logout user
     */
    public static function logout(): void
    {
        // Clear all session data
        $_SESSION = [];

        // Destroy session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }

    /**
     * Regenerate session ID (prevent session fixation)
     */
    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    /**
     * Set session expiration time
     */
    public static function setExpiry(int $seconds = 86400): void
    {
        self::set('session_expires', time() + $seconds);
    }

    /**
     * Check if session is expired
     */
    public static function isExpired(): bool
    {
        $expires = self::get('session_expires');
        if ($expires && $expires < time()) {
            return true;
        }
        return false;
    }

    /**
     * Keep session alive (extend expiration)
     */
    public static function keepAlive(int $seconds = 86400): void
    {
        self::setExpiry($seconds);
    }



    /**
     * Get all session data (for debugging)
     */
    public static function all(): array
    {
        return $_SESSION;
    }

    /**
     * Remove specific user data (for updating profile)
     */
    public static function updateUser(array $user): void
    {
        self::set('user', $user);
        if (isset($user['name'])) self::set('user_name', $user['name']);
        if (isset($user['email'])) self::set('user_email', $user['email']);
    }
}
