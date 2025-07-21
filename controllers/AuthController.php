<?php
// controllers/AuthController.php
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'RegistroInicioSesion.php';

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
                    'correo' => $usuario['correo'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'tipo_usuario' => $usuario['tipo_usuario']
                ]);
                $_SESSION['login_redirect'] = APP_URL . '/dashboard';
            } else {
                throw new Exception("Credenciales inválidas");
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['login_redirect'] = APP_URL . '/login';

        } finally {
            // Registrar el intento (éxito o fracaso)
            RegistroInicioSesion::add($loginAttempt);
            $destino = $_SESSION['login_redirect'] ?? (APP_URL . '/login');
            unset($_SESSION['login_redirect']);
            header("Location: $destino");
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