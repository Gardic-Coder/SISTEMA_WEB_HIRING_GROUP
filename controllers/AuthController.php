<?php
// controllers/AuthController.php
require_once __DIR__ . '/../utils/config.php';

class AuthController {
    public function showLogin() {
        if (Auth::check()) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
        require VIEWS_DIR . 'auth/login.php';
    }

    public function login() {
        $identifier = $_POST['identifier'] ?? ''; // Puede ser email o username
        $password = $_POST['password'] ?? '';
        $ip = $_SERVER['REMOTE_ADDR'];

        // Protección contra fuerza bruta
        $failedAttempts = RegistroInicioSesion::getFailedAttempts($ip, 30); // Últimos 30 minutos
        if ($failedAttempts >= 5) {
            $_SESSION['error'] = 'Demasiados intentos fallidos. Intente más tarde.';
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        // Registrar intento de login
        $loginAttempt = [
            'usuario_id' => null,
            'ip_usuario' => $ip,
            'exito' => false
        ];

        try {
            $usuario = Usuario::authenticate($identifier, $password);
            
            if ($usuario) {
                // Registrar login exitoso
                $loginAttempt['exito'] = true;
                $loginAttempt['usuario_id'] = $usuario['id'];
                
                Auth::login([
                    'id' => $usuario['id'],
                    'email' => $usuario['email'],
                    'username' => $usuario['username'],
                    'tipo_usuario' => $usuario['tipo_usuario']
                ]);
                
                // Redirigir al dashboard
                header('Location: ' . APP_URL . '/dashboard');
                exit;
            }
            
            throw new Exception("Credenciales inválidas");
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        } finally {
            // Registrar el intento (éxito o fracaso)
            RegistroInicioSesion::add($loginAttempt);
            header('Location: ' . APP_URL . '/login');
            exit;
        }
    }

    public function logout() {
        // Registrar logout?
        Auth::logout();
        header('Location: ' . APP_URL . '/');
        exit;
    }
}