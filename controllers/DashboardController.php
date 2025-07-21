<?php
// controllers/DashboardController.php
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';


class DashboardController {
    public function redirectToDashboard() {
        if (!Auth::check()) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }
        
        $usuario = Auth::user();

        switch ($usuario['tipo_usuario']) {
            case 'postulante':
                // Verificar si está contratado
                $postulante = UsuarioPostulante::getByField('usuario_id', $usuario['id']);
                
                if ($postulante && !empty($postulante['contratado']) && $postulante['contratado'] == 1) {
                    header('Location: ' . APP_URL . '/dashboard/contratado');
                } else {
                    header('Location: ' . APP_URL . '/dashboard/postulante');
                }
                break;
            case 'empresa':
                header('Location: ' . APP_URL . '/dashboard/empresa');
                break;
            case 'administrador':
                header('Location: ' . APP_URL . '/dashboard/admin');
                break;
            case 'hiring_group':
                header('Location: ' . APP_URL . '/dashboard/hiring');
                break;
            default:
                header('Location: ' . APP_URL . '/logout');
        }
        exit;
    }
}