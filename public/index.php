<?php
// public/index.php
require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'setup.php';
require_once CORE_DIR . 'Auth.php';

// Iniciar sesión
session_start();

// Comprobar timeout de sesión
if (isset($_SESSION['LAST_ACTIVITY'])) {
    $inactive_time = time() - $_SESSION['LAST_ACTIVITY'];
    if ($inactive_time > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
    }
}
$_SESSION['LAST_ACTIVITY'] = time();

// Inicializar la base de datos si es necesario
if (!file_exists(DB_PATH)) {
    crearTablas();
}

// Obtener la ruta solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = parse_url(APP_URL, PHP_URL_PATH);
$path = str_replace($base_path, '', $request_uri);
$path = explode('?', $path)[0]; // Eliminar parámetros GET

// Rutas definidas
$routes = [
    '/' => 'home',
    '/login' => 'login',
    '/auth' => 'auth',
    '/dashboard' => 'dashboard',
    '/logout' => 'logout',
    '/registro/postulante' => 'registroPostulante'
];

// Manejar la ruta solicitada
if (array_key_exists($path, $routes)) {
    $action = $routes[$path];
    require_once CONTROLLERS_DIR . 'PageController.php';
    $controller = new PageController();
    
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        header("HTTP/1.0 404 Not Found");
        include VIEWS_DIR . '404.php';
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include VIEWS_DIR . '404.php';
}
/*session_start();




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
*/
?>