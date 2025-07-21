<?php
// controllers/UserController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';
require_once MODELS_DIR . 'Contratacion.php';
require_once MODELS_DIR . 'Telefono.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'UsuarioEmpresa.php';
require_once UTILS_DIR . 'DocumentHandler.php';

class UserController {
    public function mostrarOfertas() {
        if (!Auth::check()) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $usuario = Usuario::getById($usuarioId);
        $tipoUsuario = $usuario['tipo_usuario'];

        // 🧾 Común para todos los usuarios
        // Ya tienes: $usuario, $usuarioId, $tipoUsuario

        // 📌 ADMINISTRADOR / HIRING GROUP
        if ($tipoUsuario === 'administrador' || $tipoUsuario === 'hiring_group') {
            // No necesitas cargar más datos
            require VIEWS_DIR . 'dashboard/ofertas.php';
            return;
        }

        // 🏢 EMPRESA
        if ($tipoUsuario === 'empresa') {
            $usuarioEmpresa = UsuarioEmpresa::getByField('usuario_id', $usuarioId);
            $empresa = Empresa::getById($usuarioEmpresa['empresa_id'] ?? null);

            require VIEWS_DIR . 'dashboard/ofertas.php';
            return;
        }

        // 🧍 POSTULANTE (NO CONTRATADO)
        if ($tipoUsuario === 'postulante') {
            $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
            $telefonos = Telefono::getByUsuario($usuarioId);
            $telefono = !empty($telefonos) ? $telefonos[0]['telefono'] : 'No disponible';

            // Verificar si está contratado
            if (!empty($postulante['contratado'])) {
                $contratacion = Contratacion::getByUsuario($usuarioId);
                // Aquí puedes incluir más datos si lo deseas, como la oferta vinculada, empresa, etc.
            }

            require VIEWS_DIR . 'dashboard/ofertas.php';
            return;
        }

        // ⚠️ Cualquier otro tipo
        $_SESSION['error'] = "Tipo de usuario no reconocido.";
        header('Location: ' . APP_URL . '/logout');
        exit;

    }
}