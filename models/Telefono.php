<?php
/**
 * Telefono.php - Modelo para teléfonos de usuarios
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class Telefono {
    /**
     * Crea la tabla de teléfonos
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS Telefono (
            ID INTEGER PRIMARY KEY AUTOINCREMENT,
            id_Usuario INTEGER NOT NULL,
            telefono TEXT NOT NULL,
            FOREIGN KEY (id_Usuario) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Agrega un teléfono a un usuario
     */
    public static function add($usuarioId, $numeroTelefono) {
        $sql = "INSERT INTO Telefono (id_Usuario, telefono) 
                VALUES (:usuario_id, :telefono)";
        
        return Database::getInstance()->preparedQuery($sql, [
            ':usuario_id' => $usuarioId,
            ':telefono' => $numeroTelefono
        ]);
    }

    /**
     * Obtiene todos los teléfonos de un usuario
     */
    public static function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM Telefono WHERE id_Usuario = :usuario_id";
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $telefonos = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $telefonos[] = $row;
        }

        return $telefonos;
    }

    /**
     * Actualiza un número de teléfono
     */
    public static function update($telefonoId, $nuevoNumero) {
        $sql = "UPDATE Telefono SET telefono = :telefono WHERE ID = :id";
        return Database::getInstance()->preparedQuery($sql, [
            ':id' => $telefonoId,
            ':telefono' => $nuevoNumero
        ]);
    }

    /**
     * Elimina un teléfono
     */
    public static function delete($telefonoId) {
        $sql = "DELETE FROM Telefono WHERE ID = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $telefonoId]);
    }

    /**
     * Elimina todos los teléfonos de un usuario
     */
    public static function deleteByUsuario($usuarioId) {
        $sql = "DELETE FROM Telefono WHERE id_Usuario = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
    }
}
?>