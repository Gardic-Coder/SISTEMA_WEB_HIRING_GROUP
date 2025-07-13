<?php
/**
 * Banco.php - Modelo para bancos
 */

require_once __DIR__ . '/../core/Database.php';

class Banco {
    /**
     * Crea la tabla de bancos
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS Banco (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL UNIQUE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Crea un nuevo banco
     */
    public static function create($nombreBanco) {
        $sql = "INSERT INTO Banco (nombre) VALUES (:nombre)";
        $db = Database::getInstance();
        
        if ($db->preparedQuery($sql, [':nombre' => $nombreBanco])) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene todos los bancos
     */
    public static function getAll() {
        $sql = "SELECT * FROM Banco";
        $result = Database::getInstance()->query($sql);
        $bancos = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $bancos[] = $row;
        }

        return $bancos;
    }

    /**
     * Obtiene un banco por ID
     */
    public static function getById($bancoId) {
        $sql = "SELECT * FROM Banco WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $bancoId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza un banco
     */
    public static function update($bancoId, $nuevoNombre) {
        $sql = "UPDATE Banco SET nombre = :nombre WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [
            ':id' => $bancoId,
            ':nombre' => $nuevoNombre
        ]);
    }

    /**
     * Elimina un banco
     */
    public static function delete($bancoId) {
        // Primero eliminamos las cuentas asociadas
        CuentaBancaria::deleteByBanco($bancoId);
        
        $sql = "DELETE FROM Banco WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $bancoId]);
    }
}
?>