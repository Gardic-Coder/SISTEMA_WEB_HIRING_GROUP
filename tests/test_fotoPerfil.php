<?php
require_once __DIR__ . '/../models/Usuario.php';

echo "=== Prueba de manejo de imágenes en Usuario ===\n";

// 1. Crear tabla y usuario de prueba
Usuario::createTable();

try {
    $userId = Usuario::create([
        'nombre_usuario' => 'imagen_test_user',
        'contraseña' => 'clave123',
        'correo' => 'imagen_test@example.com',
        'tipo_usuario' => 'postulante'
    ]);
    echo "👤 Usuario creado con ID: $userId\n";
} catch (Exception $e) {
    die("❌ Error al crear usuario: " . $e->getMessage() . "\n");
}

// 2. Imagen de prueba para subir
$img1Path = 'D:/Universidad/foto_test.jpeg'; // <-- Asegúrate de que exista
$img2Path = 'D:/Universidad/foto_test2.jpeg'; // <-- Asegúrate de que exista

if (!file_exists($img1Path) || !file_exists($img2Path)) {
    die("❌ Una o ambas imágenes de prueba no existen\n");
}

$img1 = [
    'name' => basename($img1Path),
    'type' => mime_content_type($img1Path),
    'tmp_name' => $img1Path,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($img1Path)
];

$img2 = [
    'name' => basename($img2Path),
    'type' => mime_content_type($img2Path),
    'tmp_name' => $img2Path,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($img2Path)
];

// 3. Subir imagen de perfil
try {
    echo "📤 Subiendo imagen de perfil...\n";
    $urls1 = Usuario::updateProfileImage($userId, $img1);
    echo "✅ Imagen subida:\n";
    print_r($urls1);
} catch (Exception $e) {
    echo "❌ Error al subir imagen: " . $e->getMessage() . "\n";
}

// 4. Cambiar imagen de perfil
try {
    echo "\n🔄 Cambiando imagen de perfil...\n";
    $urls2 = Usuario::updateProfileImage($userId, $img2);
    echo "✅ Imagen actualizada:\n";
    print_r($urls2);
} catch (Exception $e) {
    echo "❌ Error al cambiar imagen: " . $e->getMessage() . "\n";
}

// 5. Eliminar imagen de perfil
try {
    echo "\n🗑 Eliminando imagen de perfil...\n";
    $removed = Usuario::removeProfileImage($userId);
    echo $removed ? "✅ Imagen eliminada correctamente\n" : "❌ Error al eliminar imagen\n";
} catch (Exception $e) {
    echo "❌ Error al eliminar imagen: " . $e->getMessage() . "\n";
}

// 6. Eliminar usuario
Usuario::delete($userId);
echo "👤 Usuario eliminado\n";

echo "=== Prueba completada ===\n";
?>