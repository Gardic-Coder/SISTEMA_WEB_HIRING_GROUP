<?php
/**
 * OfertaLaboral.php - Modelo para ofertas laborales
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class OfertaLaboral {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS OfertaLaboral (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            profesion TEXT NOT NULL,
            cargo TEXT NOT NULL,
            descripcion TEXT NOT NULL,
            salario NUMERIC NOT NULL,
            modalidad TEXT NOT NULL,
            estado TEXT NOT NULL,
            ciudad TEXT NOT NULL,
            estatus BOOLEAN DEFAULT 1,
            empresa_id INTEGER NOT NULL,
            FOREIGN KEY (empresa_id) REFERENCES Empresa(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    public static function add($data) {
        $sql = "INSERT INTO OfertaLaboral 
                (profesion, cargo, descripcion, salario, modalidad, estado, ciudad, estatus, empresa_id) 
                VALUES (:profesion, :cargo, :descripcion, :salario, :modalidad, :estado, :ciudad, :estatus, :empresa_id)";
        
        $params = [
            ':profesion' => $data['profesion'],
            ':cargo' => $data['cargo'],
            ':descripcion' => $data['descripcion'],
            ':salario' => $data['salario'],
            ':modalidad' => $data['modalidad'],
            ':estado' => $data['estado'],
            ':ciudad' => $data['ciudad'],
            ':estatus' => $data['estatus'] ?? 1,
            ':empresa_id' => $data['empresa_id']
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function getAll($filters = []) {
        $sql = "SELECT * FROM OfertaLaboral WHERE 1=1";
        $params = [];

        if (isset($filters['estatus'])) {
            $sql .= " AND estatus = :estatus";
            $params[':estatus'] = $filters['estatus'];
        }

        if (isset($filters['empresa_id'])) {
            $sql .= " AND empresa_id = :empresa_id";
            $params[':empresa_id'] = $filters['empresa_id'];
        }

        if (isset($filters['profesion'])) {
            $sql .= " AND profesion LIKE :profesion";
            $params[':profesion'] = '%' . $filters['profesion'] . '%';
        }

        $sql .= " ORDER BY id DESC";

        $result = Database::getInstance()->preparedQuery($sql, $params);
        $ofertas = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ofertas[] = $row;
        }

        return $ofertas;
    }

    public static function getById($ofertaId) {
        $sql = "SELECT * FROM OfertaLaboral WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $ofertaId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    public static function update($ofertaId, $data) {
        $allowedFields = ['profesion', 'cargo', 'descripcion', 'salario', 'modalidad', 
                         'estado', 'ciudad', 'estatus', 'empresa_id'];
        $updates = [];
        $params = [':id' => $ofertaId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE OfertaLaboral SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    public static function delete($ofertaId) {
        $sql = "DELETE FROM OfertaLaboral WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $ofertaId]);
    }
}
?>