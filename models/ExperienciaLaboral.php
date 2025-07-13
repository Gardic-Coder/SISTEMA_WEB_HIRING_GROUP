<?php
/**
 * ExperienciaLaboral.php - Modelo para experiencia laboral de usuarios
 */

require_once __DIR__ . '/../core/Database.php';

class ExperienciaLaboral {
    /**
     * Crea la tabla de experiencia laboral
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ExperienciaLaboral (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            empresa TEXT NOT NULL,
            cargo TEXT NOT NULL,
            fecha_inicio DATE NOT NULL,
            fecha_fin DATE,
            descripcion TEXT,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Agrega un registro de experiencia laboral
     */
    public static function add($data) {
        $sql = "INSERT INTO ExperienciaLaboral 
                (usuario_id, empresa, cargo, fecha_inicio, fecha_fin, descripcion) 
                VALUES (:usuario_id, :empresa, :cargo, :fecha_inicio, :fecha_fin, :descripcion)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':empresa' => $data['empresa'],
            ':cargo' => $data['cargo'],
            ':fecha_inicio' => $data['fecha_inicio'],
            ':fecha_fin' => $data['fecha_fin'] ?? null,
            ':descripcion' => $data['descripcion'] ?? null
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene toda la experiencia laboral de un usuario
     */
    public static function getByUsuario($usuarioId) {
        $sql = "SELECT * FROM ExperienciaLaboral WHERE usuario_id = :usuario_id ORDER BY fecha_inicio DESC";
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $experiencias = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $experiencias[] = $row;
        }

        return $experiencias;
    }

    /**
     * Obtiene un registro específico por ID
     */
    public static function getById($experienciaId) {
        $sql = "SELECT * FROM ExperienciaLaboral WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $experienciaId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza un registro de experiencia laboral
     */
    public static function update($experienciaId, $data) {
        $allowedFields = ['empresa', 'cargo', 'fecha_inicio', 'fecha_fin', 'descripcion'];
        $updates = [];
        $params = [':id' => $experienciaId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE ExperienciaLaboral SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina un registro de experiencia laboral
     */
    public static function delete($experienciaId) {
        $sql = "DELETE FROM ExperienciaLaboral WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $experienciaId]);
    }

    /**
     * Elimina toda la experiencia laboral de un usuario
     */
    public static function deleteByUsuario($usuarioId) {
        $sql = "DELETE FROM ExperienciaLaboral WHERE usuario_id = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
    }
}
?>