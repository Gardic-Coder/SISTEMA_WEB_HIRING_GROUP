<?php
// controllers/ContratadoController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';

class ContratadoController {
    public function mostrarDashboard() {
        if (!Auth::check() || Auth::user()['tipo_usuario'] !== 'postulante') {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);

        if (!$postulante || empty($postulante['contratado']) || $postulante['contratado'] != 1) {
            // No está contratado, redirigir al dashboard general
            header('Location: ' . APP_URL . '/dashboard/postulante');
            exit;
        }

        require VIEWS_DIR . 'dashboard/contratado.php';
    }
}