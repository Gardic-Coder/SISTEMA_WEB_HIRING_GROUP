<?php
/**
 * ReporteActividad.php - Modelo para reportes de actividad
 */

require_once __DIR__ . '/../utils/Config.php';
require_once CORE_DIR . 'Database.php';

class ReporteActividad {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS ReporteActividad (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            accion TEXT NOT NULL,
            entidad_afectada TEXT,
            fecha_hora DATETIME NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    public static function add($data) {
        $sql = "INSERT INTO ReporteActividad 
                (usuario_id, accion, entidad_afectada, fecha_hora) 
                VALUES (:usuario_id, :accion, :entidad_afectada, :fecha_hora)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':accion' => $data['accion'],
            ':entidad_afectada' => $data['entidad_afectada'] ?? null,
            ':fecha_hora' => $data['fecha_hora'] ?? date('Y-m-d H:i:s')
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function getByUsuario($usuarioId, $limit = null) {
        $sql = "SELECT * FROM ReporteActividad 
                WHERE usuario_id = :usuario_id
                ORDER BY fecha_hora DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $reportes = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $reportes[] = $row;
        }

        return $reportes;
    }

    public static function getAll($filters = [], $limit = null) {
        $sql = "SELECT r.*, u.nombre_usuario 
                FROM ReporteActividad r
                JOIN Usuario u ON r.usuario_id = u.id
                WHERE 1=1";
        
        $params = [];

        if (isset($filters['accion'])) {
            $sql .= " AND r.accion = :accion";
            $params[':accion'] = $filters['accion'];
        }

        if (isset($filters['fecha_desde'])) {
            $sql .= " AND r.fecha_hora >= :fecha_desde";
            $params[':fecha_desde'] = $filters['fecha_desde'];
        }

        if (isset($filters['fecha_hasta'])) {
            $sql .= " AND r.fecha_hora <= :fecha_hasta";
            $params[':fecha_hasta'] = $filters['fecha_hasta'];
        }

        $sql .= " ORDER BY r.fecha_hora DESC";

        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
        }

        $result = Database::getInstance()->preparedQuery($sql, $params);
        $reportes = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $reportes[] = $row;
        }

        return $reportes;
    }
}
?>