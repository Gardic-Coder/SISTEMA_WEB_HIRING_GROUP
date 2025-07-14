<?php
require_once __DIR__ . '/../utils/ImageHandler.php';

echo "=== Prueba de ImageHandler ===\n";

// 1. Ruta de imagen de prueba
$testImagePath = 'D:/Universidad/foto_test.jpeg'; // <-- Asegúrate de que esta imagen exista
$testFileName = basename($testImagePath);

if (!file_exists($testImagePath)) {
    die("❌ La imagen de prueba no existe: $testImagePath\n");
}

// 2. Simular el array $_FILES
$testFile = [
    'name' => $testFileName,
    'type' => mime_content_type($testImagePath),
    'tmp_name' => $testImagePath,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($testImagePath)
];

// 3. Probar validación y guardado
try {
    echo "📤 Subiendo imagen: {$testFile['name']}\n";
    $result = ImageHandler::saveProfileImage($testFile, true); // Modo test para evitar mover archivos reales

    if ($result === false) {
        echo "❌ Error al guardar la imagen\n";
        exit;
    }

    echo "✅ Imagen guardada exitosamente\n";
    echo "🖼 Nombre original: " . $result['original'] . "\n";
    echo "📁 Versiones generadas:\n";
    print_r($result['versions']);
    echo "🌐 URLs generadas:\n";
    print_r($result['urls']);

    // 4. Probar eliminación
    echo "\n🗑 Eliminando imagen y versiones...\n";
    $deleted = ImageHandler::deleteProfileImage($result['original']);
    echo $deleted ? "✅ Imagen eliminada correctamente\n" : "❌ Error al eliminar imagen\n";

} catch (Exception $e) {
    echo "❌ Error durante la prueba: " . $e->getMessage() . "\n";
}

echo "=== Prueba completada ===\n";
?>