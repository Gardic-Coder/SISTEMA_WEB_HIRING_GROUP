<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/DocumentoUsuario.php';

echo "=== Prueba de DocumentHandler y DocumentoUsuario ===\n";

// 1. Crear un usuario de prueba (si no existe)
try {
    Usuario::createTable();
    DocumentoUsuario::createTable();
    
    $userId = Usuario::create([
        'nombre_usuario' => 'test_doc_user',
        'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
        'correo' => 'testdoc@example.com',
        'tipo_usuario' => 'postulante'
    ]);
    
    echo "Usuario de prueba creado con ID: $userId\n";
} catch (Exception $e) {
    die("Error al crear usuario de prueba: " . $e->getMessage());
}

// 2. Configurar el archivo de prueba (MODIFICA ESTA RUTA CON TU ARCHIVO REAL)
$testPdfPath = 'D:/Universidad/TemaSQL.pdf'; // <-- CAMBIAR ESTO
$testFileName = basename($testPdfPath);

// 3. Simular el array $_FILES
$testFile = [
    'name' => $testFileName,
    'type' => mime_content_type($testPdfPath),
    'tmp_name' => $testPdfPath,
    'error' => UPLOAD_ERR_OK,
    'size' => filesize($testPdfPath)
];

echo "Archivo de prueba configurado: $testFileName\n";
// Asegurarse de que el archivo existe
if (!file_exists($testPdfPath)) {
    die("El archivo de prueba no existe: $testPdfPath");
}   


// 4. Probar la subida del documento
try {
    echo "Intentando subir documento: $testFileName\n";
    
    $documentId = DocumentoUsuario::uploadAndRegister($userId, $testFile, 'cv', true);
    
    if ($documentId) {
        echo "Documento subido exitosamente! ID: $documentId\n";
        
        // Obtener información del documento
        $document = DocumentoUsuario::getById($documentId);
        echo "Información del documento:\n";
        print_r($document);
        
        // Obtener URL del documento
        $docUrl = DocumentoUsuario::getDocumentUrl($documentId);
        echo "URL del documento: $docUrl\n";
        
        // Listar documentos del usuario
        $userDocs = DocumentoUsuario::getByUsuario($userId);
        echo "Documentos del usuario:\n";
        print_r($userDocs);
        
        // Eliminar el documento (opcional, comenta si quieres conservarlo)
        $deleted = DocumentoUsuario::deleteDocument($documentId);
        echo $deleted ? "Documento eliminado correctamente\n" : "Error al eliminar documento\n";
    } else {
        echo "Error al subir documento\n";
    }
} catch (Exception $e) {
    echo "Error durante la prueba: " . $e->getMessage() . "\n";
}

// 5. Limpieza (opcional)
Usuario::delete($userId);
echo "Usuario de prueba eliminado\n";

echo "=== Prueba completada ===\n";
?>