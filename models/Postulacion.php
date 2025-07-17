<?php
/**
 * Postulacion.php - Modelo para postulaciones a ofertas laborales
 */

require_once __DIR__ . '/../utils/Config.php';
require_once CORE_DIR . 'Database.php';

class Postulacion {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS Postulacion (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER NOT NULL,
            oferta_id INTEGER NOT NULL,
            fecha DATE NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE,
            FOREIGN KEY (oferta_id) REFERENCES OfertaLaboral(id) ON DELETE CASCADE,
            UNIQUE (usuario_id, oferta_id)
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    public static function add($data) {
        $sql = "INSERT INTO Postulacion 
                (usuario_id, oferta_id, fecha) 
                VALUES (:usuario_id, :oferta_id, :fecha)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':oferta_id' => $data['oferta_id'],
            ':fecha' => $data['fecha'] ?? date('Y-m-d')
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function getByUsuario($usuarioId) {
        $sql = "SELECT p.*, o.profesion, o.cargo, o.empresa_id 
                FROM Postulacion p
                JOIN OfertaLaboral o ON p.oferta_id = o.id
                WHERE p.usuario_id = :usuario_id
                ORDER BY p.fecha DESC";
        
        $result = Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
        $postulaciones = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $postulaciones[] = $row;
        }

        return $postulaciones;
    }

    public static function getByOferta($ofertaId) {
        $sql = "SELECT p.*, u.nombre, u.apellido 
                FROM Postulacion p
                JOIN UsuarioPostulante u ON p.usuario_id = u.usuario_id
                WHERE p.oferta_id = :oferta_id
                ORDER BY p.fecha DESC";
        
        $result = Database::getInstance()->preparedQuery($sql, [':oferta_id' => $ofertaId]);
        $postulaciones = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $postulaciones[] = $row;
        }

        return $postulaciones;
    }

    public static function getById($postulacionId) {
        $sql = "SELECT * FROM Postulacion WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $postulacionId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    public static function delete($postulacionId) {
        $sql = "DELETE FROM Postulacion WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $postulacionId]);
    }

    public static function checkIfApplied($usuarioId, $ofertaId) {
        $sql = "SELECT id FROM Postulacion WHERE usuario_id = :usuario_id AND oferta_id = :oferta_id";
        $result = Database::getInstance()->preparedQuery($sql, [
            ':usuario_id' => $usuarioId,
            ':oferta_id' => $ofertaId
        ]);
        return $result->fetchArray() !== false;
    }
}
?>