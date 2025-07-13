<?php
/**
 * DocumentoUsuario.php - Modelo para documentos de usuarios
 */

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../utils/DocumentHandler.php';

class DocumentoUsuario {
    private static $documentHandler;

    public static function initialize() {
        if (!self::$documentHandler) {
            self::$documentHandler = new DocumentHandler();
        }
    }

    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS DocumentoUsuario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            nombre_original TEXT NOT NULL,
            nombre_archivo TEXT NOT NULL,
            ruta TEXT NOT NULL,
            url TEXT NOT NULL,
            tipo TEXT NOT NULL,
            tamanio INTEGER NOT NULL,
            mime_type TEXT NOT NULL,
            fecha_subida DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Sube y registra un nuevo documento
     */
    public static function uploadAndRegister($userId, $fileData, $tipo, $forceCopy = false) {
        self::initialize();
        
        try {
            // Subir el documento
            $fileInfo = self::$documentHandler->uploadDocument($userId, $fileData, $tipo, $forceCopy);
            
            // Registrar en la base de datos
            $sql = "INSERT INTO DocumentoUsuario 
                    (usuario_id, nombre_original, nombre_archivo, ruta, url, tipo, tamanio, mime_type) 
                    VALUES (:usuario_id, :nombre_original, :nombre_archivo, :ruta, :url, :tipo, :tamanio, :mime_type)";
            
            $params = [
                ':usuario_id' => $userId,
                ':nombre_original' => $fileInfo['nombre_original'],
                ':nombre_archivo' => $fileInfo['nombre_archivo'],
                ':ruta' => $fileInfo['ruta'],
                ':url' => $fileInfo['url_relativa'],
                ':tipo' => $fileInfo['tipo'],
                ':tamanio' => $fileInfo['tamanio'],
                ':mime_type' => $fileInfo['mime_type']
            ];

            $db = Database::getInstance();
            if ($db->preparedQuery($sql, $params)) {
                return $db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            // Eliminar el archivo si hubo error en la base de datos
            if (isset($fileInfo)) {
                self::$documentHandler->deleteDocument($userId, $fileInfo['nombre_archivo'], $tipo);
            }
            throw $e;
        }
    }

    /**
     * Elimina un documento (físico y registro)
     */
    public static function deleteDocument($documentId) {
        self::initialize();
        
        // Obtener información del documento
        $document = self::getById($documentId);
        if (!$document) return false;
        
        // Eliminar archivo físico
        $deleted = self::$documentHandler->deleteDocument(
            $document['usuario_id'], 
            $document['nombre_archivo'], 
            $document['tipo']
        );
        
        if ($deleted) {
            // Eliminar registro de la base de datos
            $sql = "DELETE FROM DocumentoUsuario WHERE id = :id";
            return Database::getInstance()->preparedQuery($sql, [':id' => $documentId]);
        }
        
        return false;
    }

    /**
     * Obtiene un documento por ID
     */
    public static function getById($documentId) {
        $sql = "SELECT * FROM DocumentoUsuario WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $documentId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Obtiene documentos por usuario
     */
    public static function getByUsuario($userId) {
        $sql = "SELECT * FROM DocumentoUsuario 
                WHERE usuario_id = :usuario_id
                ORDER BY fecha_subida DESC";
        
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $userId]);
        $documents = [];
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $documents[] = $row;
        }
        
        return $documents;
    }

    /**
     * Obtiene documentos por usuario y tipo
     */
    public static function getByUserAndType($userId, $type) {
        $sql = "SELECT * FROM DocumentoUsuario 
                WHERE usuario_id = :usuario_id AND tipo = :tipo
                ORDER BY fecha_subida DESC";
        
        $result = Database::getInstance()->preparedQuery($sql, [
            ':usuario_id' => $userId,
            ':tipo' => $type
        ]);
        
        $documents = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $documents[] = $row;
        }
        
        return $documents;
    }

    /**
     * Obtiene la URL pública de un documento
     */
    public static function getDocumentUrl($documentId) {
        $document = self::getById($documentId);
        return $document ? $document['url'] : null;
    }

    /**
     * Obtiene la ruta física de un documento
     */
    public static function getDocumentPath($documentId) {
        $document = self::getById($documentId);
        return $document ? $document['ruta'] : null;
    }

    /**
     * Verifica si un usuario es dueño del documento
     */
    public static function isOwner($documentId, $userId) {
        $sql = "SELECT COUNT(*) as count FROM DocumentoUsuario 
                WHERE id = :document_id AND usuario_id = :user_id";
        
        $result = Database::getInstance()->preparedQuery($sql, [
            ':document_id' => $documentId,
            ':user_id' => $userId
        ]);
        
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row && $row['count'] > 0;
    }
}

// Inicializar el manejador de documentos al cargar la clase
DocumentoUsuario::initialize();
?>