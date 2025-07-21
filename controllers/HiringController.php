<?php
// controllers/HiringController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';
require_once MODELS_DIR . 'Contratacion.php';
require_once MODELS_DIR . 'Telefono.php';
require_once MODELS_DIR . 'Usuario.php';
require_once UTILS_DIR . 'DocumentHandler.php';

class HiringController {
    public function mostrarDashboard() {
        if (!Auth::check() || Auth::user()['tipo_usuario'] !== 'hiring_group') {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $usuario = Usuario::getById($usuarioId);
        $telefonos = Telefono::getByUsuario($usuarioId);
        $telefonos = !empty($telefonos) ? $telefonos[0] : ['telefono' => 'No disponible'];

        require VIEWS_DIR . 'dashboard/hiring.php';
    }

}