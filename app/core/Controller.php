<?php
/**
 * Base Controller Class
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Core;

use App\Core\Database;

class Controller
{
    protected Database $db;
    protected array $data = [];
    protected string $layout = 'main';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->initSession();
    }

    /**
     * Initialize session if not started
     */
    protected function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Render view with data
     */
    protected function view(string $view, array $data = []): void
    {
        // Extract data to make variables available in view
        extract($data);
        extract($this->data);

        $viewPath = dirname(__DIR__) . '/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            $this->error404('View not found: ' . $view);
        }
    }

    /**
     * Render view with layout
     */
    protected function render(string $view, array $data = []): void
    {
        // Extract data to make variables available in view
        extract($data);
        extract($this->data);

        $contentPath = dirname(__DIR__) . '/views/' . $view . '.php';

        if (file_exists($contentPath)) {
            // Extract flash messages before rendering
            $flash = $this->getFlash();

            // Start output buffering for content
            ob_start();
            require $contentPath;
            $content = ob_get_clean();

            // Check if layout is disabled
            if ($this->layout === false) {
                // No layout - just output the content directly
                echo $content;
                return;
            }

            // Render with layout
            $layoutPath = dirname(__DIR__) . '/views/layouts/' . $this->layout . '.php';

            if (file_exists($layoutPath)) {
                require $layoutPath;
            } else {
                // Fallback to no layout
                echo $content;
            }
        } else {
            $this->error404('View not found: ' . $view);
        }
    }

    /**
     * Set data for view
     */
    protected function set(string $key, $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Set multiple data at once
     */
    protected function setData(array $data): self
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Get data from view data
     */
    protected function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Redirect to URL
     */
    protected function redirect(string $url, int $statusCode = 302): void
    {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    /**
     * Redirect to route
     */
    protected function redirectTo(string $route): void
    {
        $baseUrl = $this->getBaseUrl();
        $this->redirect($baseUrl . $route);
    }

    /**
     * Get base URL
     */
    protected function getBaseUrl(): string
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        
        // Fix double slashes
        $base = $protocol . '://' . $host . rtrim($scriptDir, '/') . '/';
        return rtrim($base, '/');
    }

    /**
     * Set flash message
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'][$type] = $message;
    }

    /**
     * Get flash message and remove it
     */
    protected function getFlash(string $type = null): ?array
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
     * Check if user is logged in
     */
    protected function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get current user data
     */
    protected function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Get current user ID
     */
    protected function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get current user role
     */
    protected function getUserRole(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Check if user has specific role
     */
    protected function hasRole(string $role): bool
    {
        return $this->getUserRole() === $role;
    }

    /**
     * Require login - redirect if not logged in
     */
    protected function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Please login first.');
            $this->redirectTo('/auth/login');
        }
    }

    /**
     * Require specific role - redirect if doesn't have role
     */
    protected function requireRole(string $role): void
    {
        $this->requireLogin();

        if (!$this->hasRole($role)) {
            $this->setFlash('error', 'You do not have permission to access this page.');
            $this->redirectTo('/');
        }
    }

    /**
     * Require any of the specified roles
     */
    protected function requireAnyRole(array $roles): void
    {
        $this->requireLogin();

        if (!in_array($this->getUserRole(), $roles)) {
            $this->setFlash('error', 'You do not have permission to access this page.');
            $this->redirectTo('/');
        }
    }

    /**
     * JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Success JSON response
     */
    protected function jsonSuccess(string $message, array $data = []): void
    {
        $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Error JSON response
     */
    protected function jsonError(string $message, int $statusCode = 400): void
    {
        $this->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }

    /**
     * 404 Error page
     */
    protected function error404(string $message = 'Page not found'): void
    {
        http_response_code(404);
        $this->data['title'] = '404 - Page Not Found';
        $this->data['message'] = $message;
        $this->view('errors/404', $this->data);
        exit;
    }

    /**
     * 403 Error page (Forbidden)
     */
    protected function error403(string $message = 'Access Forbidden'): void
    {
        http_response_code(403);
        $this->data['title'] = '403 - Access Forbidden';
        $this->data['message'] = $message;
        $this->view('errors/403', $this->data);
        exit;
    }

    /**
     * Sanitize input
     */
    protected function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Get current URL
     */
    protected function currentUrl(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }

    /**
     * Check if request is AJAX
     */
    protected function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
