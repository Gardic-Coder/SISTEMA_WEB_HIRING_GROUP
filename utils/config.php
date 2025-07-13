<?php
/**
 * config.php - Configuración global del proyecto
 */

// Ruta absoluta al archivo de base de datos SQLite
define('DB_PATH', __DIR__ . '/../db/database.db');

// Ruta absoluta a la carpeta donde se guardará la base de datos
define('DB_FOLDER', __DIR__ . '/../db');

// Configuración de imágenes de perfil
define('PROFILE_IMG_DIR', __DIR__ . '/../uploads/perfiles/');
define('PROFILE_IMG_SIZES', [
    'small' => ['width' => 150, 'height' => 150],
    'medium' => ['width' => 300, 'height' => 300]
]);
define('PROFILE_IMG_ALLOWED_TYPES', ['jpg', 'jpeg', 'png', 'gif']);
define('PROFILE_IMG_MAX_SIZE', 2 * 1024 * 1024); // 2MB
define('PROFILE_IMG_QUALITY', 85);

// Configuración de la aplicación
define('APP_URL', 'http://localhost/proyecto');
define('UPLOADS_URL', APP_URL . '/uploads/perfiles/');
?>