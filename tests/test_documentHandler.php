<?php
require_once __DIR__ . '/../utils/DocumentHandler.php';

echo "=== Prueba de DocumentHandler ===\n";

// 1. Configurar el archivo de prueba
$testPdfPath = 'D:/Universidad/TemaSQL.pdf'; // <-- Asegúrate de que esta ruta sea válida
$testFileName = basename($testPdfPath);

if (!file_exists($testPdfPath)) {
    die("❌ El archivo de prueba no existe: $testPdfPath\n");
}

// 2. Simular el array $_FILES
$testFile = [
    'name' => $testFileName,
    'type' => mime_content_type($testPdfPath),
    'tmp_name' => $testPdfPath,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($testPdfPath)
];

// 3. Crear instancia del manejador
$handler = new DocumentHandler();

// 4. Subir el documento
$userId = 999; // ID ficticio para pruebas
$tipo = 'cv';

try {
    echo "📤 Subiendo documento: {$testFile['name']}\n";
    $info = $handler->uploadDocument($userId, $testFile, $tipo, true);

    echo "✅ Documento subido exitosamente:\n";
    print_r($info);

    // 5. Listar documentos del usuario
    echo "\n📂 Documentos del usuario:\n";
    $docs = $handler->listUserDocuments($userId);
    print_r($docs);

    // 6. Eliminar el documento subido
    echo "\n🗑 Eliminando documento: {$info['nombre_archivo']}\n";
    $deleted = $handler->deleteDocument($userId, $info['nombre_archivo'], $tipo);
    echo $deleted ? "✅ Documento eliminado correctamente\n" : "❌ Error al eliminar documento\n";

} catch (Exception $e) {
    echo "❌ Error durante la prueba: " . $e->getMessage() . "\n";
}

echo "=== Prueba completada ===\n";
?>