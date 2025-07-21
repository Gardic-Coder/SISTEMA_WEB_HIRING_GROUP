<?php
// controllers/PostulanteController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';
require_once MODELS_DIR . 'Contratacion.php';
require_once MODELS_DIR . 'Telefono.php';
require_once MODELS_DIR . 'Usuario.php';
require_once UTILS_DIR . 'DocumentHandler.php';

class PostulanteController {
    public function mostrarDashboard() {
        if (!Auth::check() || Auth::user()['tipo_usuario'] !== 'postulante') {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $usuario = Usuario::getById($usuarioId);
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
        //$contratacion = Contratacion::getByUsuario($usuarioId);
        $telefonos = Telefono::getByUsuario($usuarioId);
        $telefonos = !empty($telefonos) ? $telefonos[0] : ['telefono' => 'No disponible'];

        /*if (!$postulante || empty($postulante['contratado']) || $postulante['contratado'] != 0) {
            // No está contratado, redirigir al dashboard general
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }*/

        require VIEWS_DIR . 'dashboard/postulante.php';
    }

    public function postularOferta() {
        if (!Auth::check() || Auth::user()['tipo_usuario'] !== 'postulante') {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $ofertaId = $_POST['oferta_id'] ?? null;

        if (empty($ofertaId)) {
            $_SESSION['error'] = "La oferta no fue especificada.";
            header('Location: ' . APP_URL . '/dashboard/ofertas');
            exit;
        }

        try {
            // Verificar si ya existe la postulación (evita duplicados por UNIQUE)
            $postulaciones = Postulacion::getByUsuario($usuarioId);
            $yaPostulado = array_filter($postulaciones, function($p) use ($ofertaId) {
                return $p['oferta_id'] == $ofertaId;
            });

            if (!empty($yaPostulado)) {
                $_SESSION['error'] = "Ya te has postulado a esta oferta.";
                header('Location: ' . APP_URL . '/dashboard/ofertas');
                exit;
            }

            // Registrar postulación
            Postulacion::add([
                'usuario_id' => $usuarioId,
                'oferta_id' => $ofertaId,
            ]);

            $_SESSION['success'] = "¡Postulación realizada con éxito!";
            header('Location: ' . APP_URL . '/dashboard/ofertas');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = "Error al postularse: " . $e->getMessage();
            header('Location: ' . APP_URL . '/dashboard/ofertas');
            exit;
        }
    }


}