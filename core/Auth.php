<?php
class Auth {
    public static function login($user) {
        $_SESSION['user'] = $user;
        $_SESSION['last_activity'] = time();
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }

    public static function check() {
        return isset($_SESSION['user']);
    }

    public static function user() {
        return $_SESSION['user'] ?? null;
    }

    public static function checkSession() {
        if (self::check() && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
            self::logout();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }

    public static function requireAuth() {
        if (!self::check() || !self::checkSession()) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }
    }

    public static function requireRole($role) {
        self::requireAuth();
        $user = self::user();
        
        if ($user['tipo_usuario'] !== $role) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
    }
}