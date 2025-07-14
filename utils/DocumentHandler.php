<?php
/**
 * DocumentHandler.php - Manejador de documentos para usuarios (versión para test y producción)
 */

require_once __DIR__ . '/config.php'; // Asegurar que las constantes están definidas
class DocumentHandler {
    private $baseUploadPath;
    private $allowedMimeTypes = [
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];
    private $maxFileSize = 5 * 1024 * 1024; // 5MB

    public function __construct() {
        $this->baseUploadPath = DOCUMENTS_DIR;
        
        // Asegurar que el directorio base existe
        if (!file_exists($this->baseUploadPath)) {
            if (!mkdir($this->baseUploadPath, 0755, true)) {
                throw new Exception("No se pudo crear el directorio base de documentos.");
            }
        }
    }

    /**
     * Sube un documento para un usuario
     */
    public function uploadDocument($userId, $file, $tipo = 'otros', $modoTest = false) {
        echo "📁 Iniciando subida de documento...\n";

        // Validaciones básicas
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error en la subida del archivo: " . $file['error']);
        }

        if ($file['size'] > $this->maxFileSize) {
            throw new Exception("El archivo excede el tamaño máximo permitido (5MB)");
        }

        // Validar tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        echo "🔍 Tipo MIME detectado: $mimeType\n";

        if (!array_key_exists($mimeType, $this->allowedMimeTypes)) {
            throw new Exception("Tipo de archivo no permitido: $mimeType");
        }

        // Crear directorio del usuario
        $userDir = $this->baseUploadPath . 'user_' . $userId . '/';
        if (!file_exists($userDir)) {
            if (!mkdir($userDir, 0755, true)) {
                throw new Exception("No se pudo crear el directorio del usuario.");
            }
        }

        // Crear subdirectorio por tipo
        $typeDir = $userDir . $tipo . '/';
        if (!file_exists($typeDir)) {
            if (!mkdir($typeDir, 0755, true)) {
                throw new Exception("No se pudo crear el subdirectorio de tipo.");
            }
        }

        // Generar nombre único
        $extension = $this->allowedMimeTypes[$mimeType];
        $filename = uniqid('doc_', true) . '.' . $extension;
        $destination = $typeDir . $filename;

        echo "📦 Guardando archivo en: $destination\n";

        // Guardar archivo
        if ($modoTest || php_sapi_name() === 'cli') {
            if (!copy($file['tmp_name'], $destination)) {
                throw new Exception("Error al copiar el archivo en modo test.");
            }
        } else {
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                throw new Exception("Error al mover el archivo subido.");
            }
        }

        if (!file_exists($destination)) {
            throw new Exception("El archivo no fue guardado correctamente.");
        }

        echo "✅ Archivo guardado exitosamente\n";

        // Retornar información
        return [
            'nombre_original' => $file['name'],
            'nombre_archivo' => $filename,
            'ruta' => $destination,
            'url_relativa' => DOCUMENTS_URL . "user_{$userId}/{$tipo}/{$filename}",
            'tipo' => $tipo,
            'tamanio' => $file['size'],
            'mime_type' => $mimeType,
            'extension' => $extension
        ];
    }

    public function deleteDocument($userId, $filename, $tipo) {
        $filePath = $this->baseUploadPath . "user_{$userId}/{$tipo}/{$filename}";
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    public function getDocumentPath($userId, $filename, $tipo) {
        return $this->baseUploadPath . "user_{$userId}/{$tipo}/{$filename}";
    }

    public function getDocumentUrl($userId, $filename, $tipo) {
        return DOCUMENTS_URL . "user_{$userId}/{$tipo}/{$filename}";
    }

    public function listUserDocuments($userId) {
        $userDir = $this->baseUploadPath . 'user_' . $userId . '/';
        $documents = [];

        if (file_exists($userDir)) {
            $types = array_diff(scandir($userDir), ['.', '..']);
            foreach ($types as $type) {
                $typeDir = $userDir . $type . '/';
                if (is_dir($typeDir)) {
                    $files = array_diff(scandir($typeDir), ['.', '..']);
                    foreach ($files as $file) {
                        $documents[] = [
                            'nombre' => $file,
                            'tipo' => $type,
                            'ruta' => $this->getDocumentPath($userId, $file, $type),
                            'url' => $this->getDocumentUrl($userId, $file, $type)
                        ];
                    }
                }
            }
        }

        return $documents;
    }
}
?>