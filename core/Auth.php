<?php
/** Auth.php - Manejo de autenticación y permisos de usuario */
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'RegistroInicioSesion.php';

class Auth {
    /**
     * Inicia sesión si las credenciales son válidas
     */
    public static function login($nombreUsuario, $contraseña) {
        $usuario = Usuario::findBy('nombre_usuario', $nombreUsuario);
        $ip = $_SERVER['REMOTE_ADDR'];
        $exito = false;

        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            $_SESSION['id'] = $usuario['id'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $exito = true;
        }

        // Registrar intento
        RegistroInicioSesion::add([
            'usuario_id' => $usuario['id'] ?? null,
            'fecha_hora' => date('Y-m-d H:i:s'),
            'ip_usuario' => $ip,
            'exito' => $exito
        ]);

        return $exito;
    }

    /**
     * Cierra la sesión actual
     */
    public static function logout() {
        session_unset();
        session_destroy();
    }

    /**
     * Verifica si hay sesión activa
     */
    public static function isLoggedIn() {
        return isset($_SESSION['id']);
    }

    /**
     * Obtiene el ID del usuario actual
     */
    public static function getCurrentUserId() {
        return $_SESSION['id'] ?? null;
    }

    /**
     * Obtiene el tipo de usuario actual
     */
    public static function getCurrentUserRole() {
        return $_SESSION['tipo_usuario'] ?? null;
    }

    /**
     * Requiere que el usuario esté logueado
     */
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /views/login.php');
            exit;
        }
    }

    /**
     * Requiere que el usuario tenga un rol específico
     */
    public static function requireRole($tipo) {
        if (!self::isLoggedIn() || $_SESSION['tipo_usuario'] !== $tipo) {
            header('Location: /views/login.php');
            exit;
        }
    }

    /**
     * Verifica si el usuario tiene uno de varios roles
     */
    public static function hasRole(array $roles) {
        return self::isLoggedIn() && in_array($_SESSION['tipo_usuario'], $roles);
    }
}
?>