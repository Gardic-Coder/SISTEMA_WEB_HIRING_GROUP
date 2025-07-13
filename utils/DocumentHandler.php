<?php
/**
 * DocumentHandler.php - Manejador de documentos para usuarios
 */

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
        $this->baseUploadPath = __DIR__ . '/../public/uploads/documents/';
        
        // Asegurar que el directorio base existe
        if (!file_exists($this->baseUploadPath)) {
            mkdir($this->baseUploadPath, 0755, true);
        }
    }

    /**
     * Sube un documento para un usuario
     * 
     * @param int $userId ID del usuario
     * @param array $file Datos del archivo ($_FILES['input_name'])
     * @param string $tipo Tipo de documento (cv, certificado, etc.)
     * @return array|false Información del archivo subido o false en caso de error
     */
    public function uploadDocument($userId, $file, $tipo = 'otros') {
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

        if (!array_key_exists($mimeType, $this->allowedMimeTypes)) {
            throw new Exception("Tipo de archivo no permitido");
        }

        // Crear directorio del usuario si no existe
        $userDir = $this->baseUploadPath . 'user_' . $userId . '/';
        if (!file_exists($userDir)) {
            mkdir($userDir, 0755, true);
        }

        // Crear subdirectorio por tipo si no existe
        $typeDir = $userDir . $tipo . '/';
        if (!file_exists($typeDir)) {
            mkdir($typeDir, 0755, true);
        }

        // Generar nombre único para el archivo
        $extension = $this->allowedMimeTypes[$mimeType];
        $filename = uniqid('doc_', true) . '.' . $extension;
        $destination = $typeDir . $filename;

        // Mover el archivo
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("No se pudo guardar el archivo");
        }

        // Retornar información del archivo
        return [
            'nombre_original' => $file['name'],
            'nombre_archivo' => $filename,
            'ruta' => $destination,
            'url_relativa' => "/uploads/documents/user_{$userId}/{$tipo}/{$filename}",
            'tipo' => $tipo,
            'tamanio' => $file['size'],
            'mime_type' => $mimeType,
            'extension' => $extension
        ];
    }

    /**
     * Elimina un documento
     * 
     * @param int $userId ID del usuario
     * @param string $filename Nombre del archivo
     * @param string $tipo Tipo de documento
     * @return bool True si se eliminó correctamente
     */
    public function deleteDocument($userId, $filename, $tipo) {
        $filePath = $this->baseUploadPath . "user_{$userId}/{$tipo}/{$filename}";
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }

    /**
     * Obtiene la ruta física de un documento
     */
    public function getDocumentPath($userId, $filename, $tipo) {
        return $this->baseUploadPath . "user_{$userId}/{$tipo}/{$filename}";
    }

    /**
     * Obtiene la URL pública de un documento
     */
    public function getDocumentUrl($userId, $filename, $tipo) {
        return "/uploads/documents/user_{$userId}/{$tipo}/{$filename}";
    }

    /**
     * Lista todos los documentos de un usuario
     */
    public function listUserDocuments($userId) {
        $userDir = $this->baseUploadPath . 'user_' . $userId . '/';
        $documents = [];
        
        if (file_exists($userDir)) {
            $types = array_diff(scandir($userDir), ['.', '..']);
            
            foreach ($types as $type) {
                if (is_dir($userDir . $type)) {
                    $files = array_diff(scandir($userDir . $type), ['.', '..']);
                    
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