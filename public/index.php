<?php
session_start();
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'setup.php';
require_once CORE_DIR . 'Auth.php';

// Crear tablas si no existen
crearTablas();

// Redirigir según sesión
if (Auth::isLoggedIn()) {
    $rol = Auth::getCurrentUserRole();
    switch ($rol) {
        case 'administrador':
            header('Location: /views/admin/dashboard.php'); break;
        case 'empresa':
            header('Location: /views/empresa/panel.php'); break;
        case 'postulante':
            header('Location: /views/postulante/perfil.php'); break;
        case 'hiring_group':
            header('Location: /views/hiring/dashboard.php'); break;
        default:
            header('Location: /views/login.php');
    }
} else {
    header('Location: /views/login.php');
}
exit;