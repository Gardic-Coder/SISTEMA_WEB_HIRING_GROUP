<?php
require_once __DIR__ . '/../utils/config.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';
require_once MODELS_DIR . 'Empresa.php';
require_once MODELS_DIR . 'OfertaLaboral.php';
require_once MODELS_DIR . 'Postulacion.php';
require_once MODELS_DIR . 'Contratacion.php';
require_once MODELS_DIR . 'Categoria.php';
require_once MODELS_DIR . 'CategoriaOfertaLaboral.php';
require_once MODELS_DIR . 'Telefono.php';
require_once MODELS_DIR . 'FormacionAcademica.php';
require_once MODELS_DIR . 'DocumentoUsuario.php';
require_once MODELS_DIR . 'CuentaBancaria.php';
require_once MODELS_DIR . 'Banco.php';
require_once MODELS_DIR . 'ExperienciaLaboral.php';
require_once MODELS_DIR . 'RegistroInicioSesion.php';
require_once MODELS_DIR . 'ReporteActividad.php';
require_once MODELS_DIR . 'NominaMensual.php';
require_once MODELS_DIR . 'DetalleNomina.php';
require_once MODELS_DIR . 'ProfesionUsuario.php';

function crearTablas() {
    Usuario::createTable();
    UsuarioPostulante::createTable();
    Empresa::createTable();
    OfertaLaboral::createTable();
    Postulacion::createTable();
    Contratacion::createTable();
    Categoria::createTable();
    CategoriaOfertaLaboral::createTable();
    Telefono::createTable();
    FormacionAcademica::createTable();
    DocumentoUsuario::createTable();
    CuentaBancaria::createTable();
    Banco::createTable();
    ExperienciaLaboral::createTable();
    RegistroInicioSesion::createTable();
    ReporteActividad::createTable();
    NominaMensual::createTable();
    DetalleNomina::createTable();
    ProfesionUsuario::createTable();
}

// Autoload para controladores
spl_autoload_register(function ($className) {
    $file = CONTROLLERS_DIR . $className . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Manejo básico de errores
set_exception_handler(function ($e) {
    error_log($e->getMessage());
    http_response_code(500);
    require VIEWS_DIR . 'errors/500.php';
    exit;
});

?>