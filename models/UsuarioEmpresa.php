<?php
/**
 * UsuarioEmpresa.php - Modelo para relación usuario-empresa
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class UsuarioEmpresa {
    /**
     * Crea la tabla de relación usuario-empresa
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS UsuarioEmpresa (
            usuario_id INTEGER NOT NULL PRIMARY KEY,
            empresa_id INTEGER NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE,
            FOREIGN KEY (empresa_id) REFERENCES Empresa(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Asocia un usuario a una empresa
     */
    public static function associate($usuarioId, $empresaId) {
        // Verificar si el usuario ya está asociado a alguna empresa
        if (self::getEmpresaByUsuario($usuarioId)) {
            throw new Exception("El usuario ya está asociado a una empresa");
        }

        // Verificar que el usuario es de tipo 'empresa'
        $usuario = Usuario::getById($usuarioId);
        if ($usuario['tipo_usuario'] !== 'empresa') {
            throw new Exception("Solo usuarios de tipo 'empresa' pueden ser asociados");
        }

        $sql = "INSERT INTO UsuarioEmpresa (usuario_id, empresa_id)
                VALUES (:usuario_id, :empresa_id)";

        $params = [
            ':usuario_id' => $usuarioId,
            ':empresa_id' => $empresaId
        ];

        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Obtiene la empresa asociada a un usuario (null si no tiene)
     */
    public static function getEmpresaByUsuario($usuarioId) {
        $sql = "SELECT e.* FROM Empresa e
                JOIN UsuarioEmpresa ue ON e.id = ue.empresa_id
                WHERE ue.usuario_id = :usuario_id
                LIMIT 1";

        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza la asociación de un usuario a otra empresa
     */
    public static function updateAssociation($usuarioId, $nuevaEmpresaId) {
        $db = Database::getInstance();
        
        try {
            $db->execQuery('BEGIN TRANSACTION');
            
            // Primero eliminamos cualquier asociación existente
            self::disassociate($usuarioId, self::getEmpresaByUsuario($usuarioId)['id']);
            
            // Luego creamos la nueva asociación
            $sql = "INSERT INTO UsuarioEmpresa (usuario_id, empresa_id)
                    VALUES (:usuario_id, :empresa_id)";
            
            $params = [
                ':usuario_id' => $usuarioId,
                ':empresa_id' => $nuevaEmpresaId
            ];
            
            $result = $db->preparedQuery($sql, $params);
            
            $db->execQuery('COMMIT');
            return $result;
            
        } catch (Exception $e) {
            $db->execQuery('ROLLBACK');
            throw $e;
        }
    }

    /**
     * Elimina la asociación de un usuario con una empresa
     */
    public static function disassociate($usuarioId, $empresaId) {
        $sql = "DELETE FROM UsuarioEmpresa 
                WHERE usuario_id = :usuario_id AND empresa_id = :empresa_id";

        $params = [
            ':usuario_id' => $usuarioId,
            ':empresa_id' => $empresaId
        ];

        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina todas las asociaciones de una empresa
     */
    public static function deleteByEmpresa($empresaId) {
        $sql = "DELETE FROM UsuarioEmpresa WHERE empresa_id = :empresa_id";
        return Database::getInstance()->preparedQuery($sql, [':empresa_id' => $empresaId]);
    }

    /**
     * Obtiene todos los usuarios de una empresa
     */
    public static function getUsuariosByEmpresa($empresaId) {
        $sql = "SELECT u.* FROM Usuario u
                JOIN UsuarioEmpresa ue ON u.id = ue.usuario_id
                WHERE ue.empresa_id = :empresa_id";

        $result = Database::getInstance()->preparedQuery($sql, [':empresa_id' => $empresaId]);
        $usuarios = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $usuarios[] = $row;
        }

        return $usuarios;
    }

    /**
     * Verifica si un usuario está asociado a una empresa
     */
    public static function isAssociated($usuarioId, $empresaId) {
        $sql = "SELECT 1 FROM UsuarioEmpresa
                WHERE usuario_id = :usuario_id AND empresa_id = :empresa_id
                LIMIT 1";

        $result = Database::getInstance()->preparedQuery($sql, [
            ':usuario_id' => $usuarioId,
            ':empresa_id' => $empresaId
        ]);

        return (bool) $result->fetchArray();
    }
}
?>