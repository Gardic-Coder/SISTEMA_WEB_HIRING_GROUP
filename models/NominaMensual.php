<?php
/**
 *  NominaMensual.php - Modelo para la nomina mensual
 */

require_once __DIR__ . '/../core/Database.php';

class NominaMensual{
    /**
     * Crea la tabla de nomina mensual
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS NominaMensual (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            empresa_id INTEGER NOT NULL,
            mes TEXT NOT NULL,
            año INTEGER NOT NULL,
            FOREIGN KEY (empresa_id) REFERENCES Empresa(id) ON DELETE CASCADE
        )";

        return Database::getInstance()->execQuery($sql);
    }

    /**
     *   Crea una nueva nomina
     */
    public static function create($data){
        $sql = "INSERT NominaMensual (empresa_id, mes, año)
                VALUES (:empresa_id, :mes, :año)";
        
        $params = [
            ':empresa_id' => $data['empresa_id'],
            ':mes' => $data['mes'],
            ':año' => $data
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)){
            return $db->lastInsertId();

        }
        return false;
    }

    /**
     * Obtener nomina por ID
     */
    public static function getById($nominaId) {
        $sql = "SELECT * FROM NominaMensual WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $nominaId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
        }

    /**
     * Obtener nomina por empresa
     */
    public static function getByCompany($empresaId){
        $sql = "SELECT * FROM NominaMensual WHERE empresa_id = :empresa_id";
        $result = Database::getInstance()->preparedQuery($sql, [':empresa_id' => $empresaId]);
        $nominas = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $nominas[] = $row;
        }

        return $nominas;
    }

    /**
     * Actualiza un registo de nomina mensual
     */
    public static function update($nominaId, $data){
        $allowedFields = ['mes', 'año'];
        $updates = [];
        $params = [':id' => $nominaId];
        
        foreach($data as $key => $value){
            if(in_array($key, $allowedFields)){
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE NominaMensual SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Eliminar un registro de nomina
     */
    public static function delete($nominaId){
        $sql = "DELETE FROM NominaMensual WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $nominaId]);
    }

    /**
     * Eliminar todas las nominas de una empresa
     */
    public static function deleteByCompany($empresaId){
        $sql = "DELETE FROM NominaMensual WHERE empresaId = :empresaId";
        return Database::getInstance()->preparedQuery($sql, [':empresaId' => $empresaId]);
    }

}
?>