<?php
/**
 * RegistroInicioSesion.php - Modelo para registros de inicio de sesión
 */

require_once __DIR__ . '/../util/Config.php';
require_once CORE_DIR . 'Database.php';

class RegistroInicioSesion {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS RegistroInicioSesion (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            fecha_hora DATETIME NOT NULL,
            ip_usuario TEXT NOT NULL,
            exito BOOLEAN NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    public static function add($data) {
        $sql = "INSERT INTO RegistroInicioSesion 
                (usuario_id, fecha_hora, ip_usuario, exito) 
                VALUES (:usuario_id, :fecha_hora, :ip_usuario, :exito)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':fecha_hora' => $data['fecha_hora'] ?? date('Y-m-d H:i:s'),
            ':ip_usuario' => $data['ip_usuario'],
            ':exito' => $data['exito'] ? 1 : 0
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function getByUsuario($usuarioId, $limit = null) {
        $sql = "SELECT * FROM RegistroInicioSesion 
                WHERE usuario_id = :usuario_id
                ORDER BY fecha_hora DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $registros = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $registros[] = $row;
        }

        return $registros;
    }

    public static function getFailedAttempts($ipUsuario, $minutes = 30) {
        $sql = "SELECT COUNT(*) as intentos 
                FROM RegistroInicioSesion 
                WHERE ip_usuario = :ip_usuario 
                AND exito = 0 
                AND fecha_hora >= datetime('now', '-' || :minutes || ' minutes')";
        
        $result = Database::getInstance()->preparedQuery($sql, [
            ':ip_usuario' => $ipUsuario,
            ':minutes' => $minutes
        ]);
        
        $row = $result->fetchArray(SQLITE3_ASSOC);
        return $row ? $row['intentos'] : 0;
    }

    public static function getLastSuccess($usuarioId) {
        $sql = "SELECT * FROM RegistroInicioSesion 
                WHERE usuario_id = :usuario_id 
                AND exito = 1
                ORDER BY fecha_hora DESC
                LIMIT 1";
        
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }
}
?>