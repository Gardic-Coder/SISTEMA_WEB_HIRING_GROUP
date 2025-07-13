<?php
/**
 * CuentaBancaria.php - Modelo para cuentas bancarias de usuarios
 */

require_once __DIR__ . '/../core/Database.php';

class CuentaBancaria {
    /**
     * Crea la tabla de cuentas bancarias
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS CuentaBancaria (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            banco_id INTEGER NOT NULL,
            nro_cuenta TEXT NOT NULL,
            tipo_cuenta TEXT CHECK(tipo_cuenta IN ('ahorro', 'corriente')) NOT NULL,
            activa BOOLEAN DEFAULT 1,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE,
            FOREIGN KEY (banco_id) REFERENCES Banco(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Crea una nueva cuenta bancaria
     */
    public static function create($data) {
        $sql = "INSERT INTO CuentaBancaria (usuario_id, banco_id, nro_cuenta, tipo_cuenta)
                VALUES (:usuario_id, :banco_id, :nro_cuenta, :tipo_cuenta)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':banco_id' => $data['banco_id'],
            ':nro_cuenta' => $data['nro_cuenta'],
            ':tipo_cuenta' => $data['tipo_cuenta']
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene todas las cuentas de un usuario
     */
    public static function getByUsuario($usuarioId) {
        $sql = "SELECT cb.*, b.nombre as banco_nombre 
                FROM CuentaBancaria cb
                JOIN Banco b ON cb.banco_id = b.id
                WHERE cb.usuario_id = :usuario_id";
        
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $cuentas = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $cuentas[] = $row;
        }

        return $cuentas;
    }

    /**
     * Obtiene una cuenta por ID
     */
    public static function getById($cuentaId) {
        $sql = "SELECT cb.*, b.nombre as banco_nombre 
                FROM CuentaBancaria cb
                JOIN Banco b ON cb.banco_id = b.id
                WHERE cb.id = :id";
        
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $cuentaId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza una cuenta bancaria
     */
    public static function update($cuentaId, $data) {
        $allowedFields = ['banco_id', 'nro_cuenta', 'tipo_cuenta', 'activa'];
        $updates = [];
        $params = [':id' => $cuentaId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE CuentaBancaria SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina una cuenta bancaria
     */
    public static function delete($cuentaId) {
        $sql = "DELETE FROM CuentaBancaria WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $cuentaId]);
    }

    /**
     * Elimina todas las cuentas de un usuario
     */
    public static function deleteByUsuario($usuarioId) {
        $sql = "DELETE FROM CuentaBancaria WHERE usuario_id = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
    }

    /**
     * Elimina todas las cuentas de un banco
     */
    public static function deleteByBanco($bancoId) {
        $sql = "DELETE FROM CuentaBancaria WHERE banco_id = :banco_id";
        return Database::getInstance()->preparedQuery($sql, [':banco_id' => $bancoId]);
    }
}
?>