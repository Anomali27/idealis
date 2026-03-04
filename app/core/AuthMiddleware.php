<?php
/**
 * Authentication Middleware
 * PIC Social Activity & Volunteer Management System
 */

namespace App\Core;

class AuthMiddleware
{
    /**
     * Check if user is logged in
     */
    public static function handle(): void
    {
        if (!Session::isLoggedIn()) {
            Session::setFlash('error', 'Please login first to access this page.');
            self::redirectToLogin();
        }
    }

    /**
     * Check if user has specific role
     */
    public static function handleRole(string $role): void
    {
        self::handle();

        if (!Session::hasRole($role)) {
            Session::setFlash('error', 'You do not have permission to access this page.');
            self::redirectToDashboard();
        }
    }

    /**
     * Check if user has any of the specified roles
     */
    public static function handleAnyRole(array $roles): void
    {
        self::handle();

        if (!Session::hasAnyRole($roles)) {
            Session::setFlash('error', 'You do not have permission to access this page.');
            self::redirectToDashboard();
        }
    }

    /**
     * Check if user is guest (not logged in)
     */
    public static function handleGuest(): void
    {
        if (Session::isLoggedIn()) {
            self::redirectToDashboard();
        }
    }

    /**
     * Redirect to login page
     */
    private static function redirectToLogin(): void
    {
        header('Location: /auth/login');
        exit;
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    private static function redirectToDashboard(): void
    {
        $role = Session::getUserRole();
        $redirects = [
            'admin' => '/admin/dashboard',
            'committee' => '/committee/dashboard',
            'student' => '/student/dashboard',
            'teacher' => '/teacher/dashboard'
        ];
        
        $redirect = $redirects[$role] ?? '/';
        header('Location: ' . $redirect);
        exit;
    }

    /**
     * Get current user ID
     */
    public static function getUserId(): ?int
    {
        return Session::getUserId();
    }

    /**
     * Get current user role
     */
    public static function getUserRole(): ?string
    {
        return Session::getUserRole();
    }

    /**
     * Get current user data
     */
    public static function getUser(): ?array
    {
        return Session::getUser();
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin(): bool
    {
        return Session::hasRole('admin');
    }

    /**
     * Check if user is committee
     */
    public static function isCommittee(): bool
    {
        return Session::hasRole('committee');
    }

    /**
     * Check if user is student
     */
    public static function isStudent(): bool
    {
        return Session::hasRole('student');
    }

    /**
     * Check if user is teacher
     */
    public static function isTeacher(): bool
    {
        return Session::hasRole('teacher');
    }
}
