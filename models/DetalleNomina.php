<?php
    /**
     * DetalleNomina.php - Modelo de detalles de la nomina
     */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class DetalleNomina{

    /**
     * Crea una tabla de detalleNomina
     */
    public static function createTable(){
        $sql="CREATE TABLE IF NOT EXISTS DetalleNomina (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nomina_id INTEGER NOT NULL,
            usuario_id INTEGER NOT NULL,
            salario_base NUMERIC NOT NULL,
            descuento_ivss NUMERIC NOT NULL,
            descuento_inces NUMERIC NOT NULL,
            porcentaje_hiring_group NUMERIC NOT NULL,
            salario_neto NUMERIC NOT NULL,
            FOREIGN KEY (nomina_id) REFERENCES Nomina(id) ON DELETE CASCADE,
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";

        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Agrega detalles a la nomina
     */
    public static function add($data){
        $sql = "INSERT INTO DetalleNomina (nomina_id, usuario_id, salario_base, descuento_ivss, descuento_inces, porcentaje_hiring_group, salario_neto)
                VALUES (:nomina_id, :usuario_id, :salario_base, :descuento_ivss, :descuento_inces, :porcentaje_hiring_group, :salario_neto)";

        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':nomina_id' => $data['nomina_id'],
            ':salario_base' => $data['salario_base'],
            ':descuento_ivss' => $data['descuento_ivss'],
            ':descuento_inces' => $data['descuento_inces'],
            ':porcentaje_hiring_group' => $data['porcentaje_hiring_group'],
            ':salario_neto' => $data['salario_neto']
        ]; 

        $db = Database::getInstance();
        if($db->preparedQuery($sql, $params)){
            return $db -> lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene los detalles por ID
     */
    public static function getById($nominaId){
        $sql = "SELECT * FROM DetalleNomina WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $nominaId]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Obtiene los detalles por nomina
     */
    public static function getByNomina($nominaId) {
        $sql = "SELECT * FROM DetalleNomina WHERE nomina_id = :nomina_id ORDER BY id DESC";
        $result = Database::getInstance()->preparedQuery($sql, [':nomina_id' => $nominaId]);
        $detalles = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $detalles[] = $row;
        }
        return $detalles;
    }

    /**
     * Elimina un detalle por su ID
     */
    public static function deleteById($id) {
        $sql = "DELETE FROM DetalleNomina WHERE id = :id";
        $params = [':id' => $id];
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina todos los detalles de una nómina por nomina_id
     */
    public static function deleteByNomina($nominaId) {
        $sql = "DELETE FROM DetalleNomina WHERE nomina_id = :nomina_id";
        $params = [':nomina_id' => $nominaId];
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina todos los detalles de nómina por usuario_id
     */
    public static function deleteByUsuario($usuarioId) {
        $sql = "DELETE FROM DetalleNomina WHERE usuario_id = :usuario_id";
        $params = [':usuario_id' => $usuarioId];
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Actualiza un detalle de nómina por su ID
     */
    public static function update($detalleId, $data) {
        $allowedFields = ['nomina_id', 'usuario_id', 'salario_base', 'descuento_ivss', 'descuento_inces', 'porcentaje_hiring_group', 'salario_neto' ];
        $updates = [];
        $params = [':id' => $detalleId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE DetalleNomina SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);

    }
}
?>