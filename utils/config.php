<?php
/**
 * config.php - Configuración global del proyecto
 */

// === 🗂️ Rutas base del proyecto ===
define('PROJECT_ROOT', dirname(__DIR__)); // Raíz del proyecto
define('CORE_DIR', PROJECT_ROOT . '/core/');
define('UTILS_DIR', PROJECT_ROOT . '/utils/');
define('MODELS_DIR', PROJECT_ROOT . '/models/');
define('DB_FOLDER', PROJECT_ROOT . '/db/');
define('PUBLIC_DIR', PROJECT_ROOT . '/public/');
define('CONTROLLERS_DIR', PROJECT_ROOT . '/controllers/');
define('VIEWS_DIR', PUBLIC_DIR . 'views/');
define('ASSETS_DIR', PUBLIC_DIR . 'assets/');
define('CONFIG_DIR', UTILS_DIR . 'config/');

// === 🗃️ Base de datos ===
define('DB_PATH', DB_FOLDER . 'database.sqlite');

// === 👤 Imágenes de perfil ===
define('PROFILE_IMG_DIR', PUBLIC_DIR . 'uploads/perfiles/');
define('PROFILE_IMG_SIZES', [
    'small' => ['width' => 150, 'height' => 150],
    'medium' => ['width' => 300, 'height' => 300]
]);
define('PROFILE_IMG_ALLOWED_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
define('PROFILE_IMG_MAX_SIZE', 2 * 1024 * 1024); // 2MB
define('PROFILE_IMG_QUALITY', 85);
define('PROFILE_IMG_URL', '/uploads/perfiles/');

// === 📄 Documentos de usuario ===
define('DOCUMENTS_DIR', PUBLIC_DIR . 'uploads/documents/');
define('DOCUMENTS_URL', '/uploads/documents/');

// === 🌐 Configuración de la aplicación ===
define('APP_URL', 'http://localhost:8000');
define('UPLOADS_URL', APP_URL . '/uploads/perfiles/');

// === 📦 Rutas comunes para require_once ===
// Úsalas así: require_once CORE_DIR . 'Database.php';
define('DOCUMENT_HANDLER_PATH', UTILS_DIR . 'DocumentHandler.php');
define('IMAGE_HANDLER_PATH', UTILS_DIR . 'ImageHandler.php');
define('CONFIG_PATH', CONFIG_DIR . 'config.php');

// === 🔐 Configuración de autenticación ===
define('SESSION_TIMEOUT', 1800); // 30 minutos de inactividad

// === 🧪 Otros valores útiles ===
date_default_timezone_set('America/Caracas');
?>