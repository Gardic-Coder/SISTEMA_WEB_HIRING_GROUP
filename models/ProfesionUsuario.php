<?php
/**
 * ProfesionUsuario.php - Modelo para profesiones de usuarios
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class ProfesionUsuario {
    /**
     * Crea la tabla de profesiones de usuarios
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ProfesionUsuario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            profesion TEXT NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Agrega una profesión a un usuario
     */
    public static function add($usuarioId, $profesion) {
        $sql = "INSERT INTO ProfesionUsuario (usuario_id, profesion) 
                VALUES (:usuario_id, :profesion)";
        
        $params = [
            ':usuario_id' => $usuarioId,
            ':profesion' => $profesion
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene todas las profesiones de un usuario
     */
    public static function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM ProfesionUsuario WHERE usuario_id = :usuario_id";
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $profesiones = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $profesiones[] = $row;
        }

        return $profesiones;
    }

    /**
     * Actualiza una profesión
     */
    public static function update($profesionId, $nuevaProfesion) {
        $sql = "UPDATE ProfesionUsuario SET profesion = :profesion WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [
            ':id' => $profesionId,
            ':profesion' => $nuevaProfesion
        ]);
    }

    /**
     * Elimina una profesión
     */
    public static function delete($profesionId) {
        $sql = "DELETE FROM ProfesionUsuario WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $profesionId]);
    }

    /**
     * Elimina todas las profesiones de un usuario
     */
    public static function deleteByUsuario($usuarioId) {
        $sql = "DELETE FROM ProfesionUsuario WHERE usuario_id = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
    }
}
?>