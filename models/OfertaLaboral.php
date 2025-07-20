<?php
/** OfertaLaboral.php - Modelo para ofertas laborales */

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
            fecha_creacion DATE DEFAULT CURRENT_DATE,
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

        // Filtros permitidos
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

        if (isset($filters['modalidad'])) {
            $sql .= " AND modalidad = :modalidad";
            $params[':modalidad'] = $filters['modalidad'];
        }

        if (isset($filters['estado'])) {
            $sql .= " AND estado = :estado";
            $params[':estado'] = $filters['estado'];
        }

        if (isset($filters['ciudad'])) {
            $sql .= " AND ciudad = :ciudad";
            $params[':ciudad'] = $filters['ciudad'];
        }

        // Ordenamiento flexible
        $allowedOrderFields = ['id', 'salario', 'fecha_creacion'];
        $orderField = isset($filters['order_by']) && in_array($filters['order_by'], $allowedOrderFields)
            ? $filters['order_by']
            : 'id';

        $orderDirection = isset($filters['order_direction']) && strtolower($filters['order_direction']) === 'asc'
            ? 'ASC'
            : 'DESC';

        $sql .= " ORDER BY $orderField $orderDirection";

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