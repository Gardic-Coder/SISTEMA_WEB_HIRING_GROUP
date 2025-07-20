<?php
// controllers/DashboardController.php
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';


class DashboardController {
    public function redirectToDashboard() {
        if (!Auth::check()) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }
        
        switch (Auth::user()['tipo_usuario']) {
            case 'postulante':
                header('Location: ' . APP_URL . '/dashboard/postulante');
                break;
            case 'empresa':
                header('Location: ' . APP_URL . '/dashboard/empresa');
                break;
            case 'administrador':
            case 'hiring_group':
                header('Location: ' . APP_URL . '/dashboard/admin');
                break;
            default:
                header('Location: ' . APP_URL . '/logout');
        }
        exit;
    }
}