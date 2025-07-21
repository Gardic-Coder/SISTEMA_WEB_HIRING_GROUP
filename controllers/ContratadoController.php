<?php
// controllers/ContratadoController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';
require_once MODELS_DIR . 'Contratacion.php';
require_once MODELS_DIR . 'Telefono.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'OfertaLaboral.php';
require_once MODELS_DIR . 'Empresa.php';
require_once MODELS_DIR . 'CuentaBancaria.php';
require_once UTILS_DIR . 'DocumentHandler.php';
require_once UTILS_DIR . 'fpdf/fpdf.php';

class ContratadoController {
    public function mostrarDashboard() {
        if (!Auth::check() || Auth::user()['tipo_usuario'] !== 'postulante') {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $usuario = Usuario::getById($usuarioId);
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
        $contratacion = Contratacion::getByUsuario($usuarioId);
        $telefonos = Telefono::getByUsuario($usuarioId);
        $telefonos = !empty($telefonos) ? $telefonos[0] : ['telefono' => 'No disponible'];

        if (!$postulante || empty($postulante['contratado']) || $postulante['contratado'] != 1) {
            // No está contratado, redirigir al dashboard general
            header('Location: ' . APP_URL . '/dashboard/postulante');
            exit;
        }

        require VIEWS_DIR . 'dashboard/contratado.php';
    }

    public function generarConstanciaTrabajo() {
        if (!Auth::check() || Auth::user()['tipo_usuario'] !== 'postulante') {
            header('Location: ' . APP_URL . '/login');
            exit;
        }
        //$this->verificarAutenticacion();

        $usuarioId = Auth::user()['id'];
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);

        if (!$postulante || empty($postulante['contratado'])) {
            $_SESSION['error'] = "No tienes autorización para generar constancia.";
            header('Location: ' . APP_URL . '/dashboard/postulante');
            exit;
        }

        $contratacion = Contratacion::getByUsuario($usuarioId);
        $oferta = OfertaLaboral::getById($contratacion[0]['oferta_id']);
        $empresa = Empresa::getById($oferta['empresa_id']);

        // Construir datos
        $nombre = $postulante['nombre'] . ' ' . $postulante['apellido'];
        $fechaInicio = date('d/m/Y', strtotime($contratacion[0]['fecha_inicio']));
        $cargo = $oferta['cargo'] ?? 'No especificado';
        $nombreEmpresa = $empresa['razon_social'] ?? 'No registrada';
        $salario = $contratacion[0]['salario'] ?? $oferta['salario'] ?? 'No definido';
        $fechaActual = date('d/m/Y');
        $ciudad = $postulante['ciudad_residencia'];

        // Crear PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $contenido = "A QUIEN PUEDA INTERESAR\n\n" .
            "Por medio de la presente, la empresa HIRING GROUP hace constar que el ciudadano(a) $nombre labora con nosotros desde $fechaInicio, cumpliendo funciones en el cargo de $cargo en la empresa $nombreEmpresa, devengando un salario mensual de $salario.\n\n" .
            "Constancia que se pide por la parte interesada en la ciudad de $ciudad en fecha $fechaActual.";
        $texto = mb_convert_encoding($contenido, 'ISO-8859-1', 'UTF-8');
        $pdf->MultiCell(0, 10, $texto);

        ob_clean(); // Limpia el buffer antes de generar PDF

        // Nombre del archivo
        $nombreArchivo = 'ConstanciaTrabajo_' . preg_replace('/\s+/', '_', $nombre) . '.pdf';
        $pdf->Output('I', $nombreArchivo);
        exit;
    }


}