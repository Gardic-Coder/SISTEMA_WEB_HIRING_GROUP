<?php
// public/index.php
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'setup.php';
require_once CORE_DIR . 'Auth.php';
require_once CORE_DIR . 'Router.php'; // Agregamos el enrutador mejorado

// Iniciar sesión
session_start();

// Verificar y actualizar actividad de sesión
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $inactive_time = time() - $_SESSION['LAST_ACTIVITY'];
    if ($inactive_time > SESSION_TIMEOUT) {
        Auth::logout();
    }
}
$_SESSION['LAST_ACTIVITY'] = time();

// Inicializar la base de datos si es necesario
if (!file_exists(DB_PATH)) {
    crearTablas();
}

// Crear instancia del enrutador
$router = new Router();

// ======= RUTAS PÚBLICAS =======
//$router->add('GET', '/', 'AuthController@showLogin');
$router->add('GET', '/', function() {
    require VIEWS_DIR . 'home.php';
});
$router->add('GET', '/login', function() {
    require VIEWS_DIR . 'auth/login.php';
});

$router->add('POST', '/auth', 'AuthController@login');
$router->add('GET', '/logout', 'AuthController@logout');
$router->add('GET', '/registro/postulante', 'RegistroController@showRegistroPostulante');
$router->add('POST', '/registro/postulante', 'RegistroController@registrarPostulante');

// ======= RUTAS PROTEGIDAS =======
$router->add('GET', '/dashboard', 'DashboardController@redirectToDashboard');
$router->add('GET', '/dashboard/postulante', 'PostulanteController@mostrarDashboard');
$router->add('GET', '/dashboard/contratado', 'ContratadoController@mostrarDashboard');
$router->add('GET', '/dashboard/hiring', 'HiringController@mostrarDashboard');
$router->add('GET', '/dashboard/ofertas', 'UserController@mostrarOfertas');
$router->add('POST', '/postular', 'PostulanteController@postularOferta');
//$router->add('GET', '/dashboard/empresa', 'EmpresaController@dashboard');
$router->add('GET', '/perfil', 'PerfilController@showProfile');
$router->add('GET', '/perfil/postulante/editar', 'RegistroController@mostrarEdicionPostulante');
$router->add('POST', '/perfil/actualizar', 'RegistroController@actualizarPerfilGeneral');


// Manejar la ruta solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = parse_url(APP_URL, PHP_URL_PATH);
if (!$base_path) {
    $base_path = '';
}
$path = str_replace($base_path, '', $request_uri);
$path = explode('?', $path)[0]; // Eliminar parámetros GET

$router->dispatch($path);
?>