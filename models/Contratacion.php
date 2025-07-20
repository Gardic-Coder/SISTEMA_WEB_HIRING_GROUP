<?php
/**
 * Contratacion.php - Modelo para contrataciones
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class Contratacion {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS Contratacion (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            oferta_id INTEGER NOT NULL,
            cuenta_bancaria_id INTEGER NOT NULL,
            fecha_inicio DATE NOT NULL,
            duracion TEXT NOT NULL,
            fecha_fin DATE,
            activo BOOLEAN DEFAULT 1,
            salario NUMERIC NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE,
            FOREIGN KEY (oferta_id) REFERENCES OfertaLaboral(id) ON DELETE CASCADE,
            FOREIGN KEY (cuenta_bancaria_id) REFERENCES CuentaBancaria(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    public static function add($data) {
        $sql = "INSERT INTO Contratacion 
                (usuario_id, oferta_id, cuenta_bancaria_id, fecha_inicio, duracion, salario) 
                VALUES (:usuario_id, :oferta_id, :cuenta_bancaria_id, :fecha_inicio, :duracion, :salario)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':oferta_id' => $data['oferta_id'],
            ':cuenta_bancaria_id' => $data['cuenta_bancaria_id'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':duracion' => $data['duracion'],
            ':fecha_fin' => isset($data['fecha_fin']) ? $data['fecha_fin'] : null,
            ':activo' => isset($data['activo']) ? $data['activo'] : 1,
            ':salario' => $data['salario']
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function getByUsuario($usuarioId) {
        $sql = "SELECT c.*, o.profesion, o.cargo, o.empresa_id 
                FROM Contratacion c
                JOIN OfertaLaboral o ON c.oferta_id = o.id
                WHERE c.usuario_id = :usuario_id
                ORDER BY c.fecha_inicio DESC";
        
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $contrataciones = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $contrataciones[] = $row;
        }

        return $contrataciones;
    }

    public static function getByEmpresa($empresaId) {
        $sql = "SELECT c.*, u.nombre, u.apellido, o.profesion, o.cargo 
                FROM Contratacion c
                JOIN UsuarioPostulante u ON c.usuario_id = u.usuario_id
                JOIN OfertaLaboral o ON c.oferta_id = o.id
                WHERE o.empresa_id = :empresa_id
                ORDER BY c.fecha_inicio DESC";
        
        $result = Database::getInstance()->preparedQuery($sql, [':empresa_id' => $empresaId]);
        $contrataciones = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $contrataciones[] = $row;
        }

        return $contrataciones;
    }

    public static function getById($contratacionId) {
        $sql = "SELECT * FROM Contratacion WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $contratacionId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    public static function update($contratacionId, $data) {
        $allowedFields = ['cuenta_bancaria_id', 'duracion', 'salario', 'fecha_fin', 'activo'];
        $updates = [];
        $params = [':id' => $contratacionId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE Contratacion SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    public static function delete($contratacionId) {
        $sql = "DELETE FROM Contratacion WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $contratacionId]);
    }
}
?>