<?php
/**
 * FormacionAcademica.php - Modelo para formación académica de usuarios
 */

require_once __DIR__ . '/../core/Database.php';

class FormacionAcademica {
    /**
     * Crea la tabla de formación académica
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS FormacionAcademica (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            institucion TEXT NOT NULL,
            carrera TEXT NOT NULL,
            nivel TEXT CHECK(nivel IN ('tecnico', 'licenciatura', 'maestria', 'doctorado')) NOT NULL,
            fecha_egreso DATE,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Agrega un registro de formación académica
     */
    public static function add($data) {
        $sql = "INSERT INTO FormacionAcademica 
                (usuario_id, institucion, carrera, nivel, fecha_egreso) 
                VALUES (:usuario_id, :institucion, :carrera, :nivel, :fecha_egreso)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':institucion' => $data['institucion'],
            ':carrera' => $data['carrera'],
            ':nivel' => $data['nivel'],
            ':fecha_egreso' => $data['fecha_egreso'] ?? null
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene toda la formación académica de un usuario
     */
    public static function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM FormacionAcademica WHERE usuario_id = :usuario_id";
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $formaciones = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $formaciones[] = $row;
        }

        return $formaciones;
    }

    /**
     * Obtiene un registro específico por ID
     */
    public static function getById($formacionId) {
        $sql = "SELECT * FROM FormacionAcademica WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $formacionId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza un registro de formación académica
     */
    public static function update($formacionId, $data) {
        $allowedFields = ['institucion', 'carrera', 'nivel', 'fecha_egreso'];
        $updates = [];
        $params = [':id' => $formacionId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE FormacionAcademica SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina un registro de formación académica
     */
    public static function delete($formacionId) {
        $sql = "DELETE FROM FormacionAcademica WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $formacionId]);
    }

    /**
     * Elimina toda la formación académica de un usuario
     */
    public static function deleteByUsuario($usuarioId) {
        $sql = "DELETE FROM FormacionAcademica WHERE usuario_id = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
    }
}
?>