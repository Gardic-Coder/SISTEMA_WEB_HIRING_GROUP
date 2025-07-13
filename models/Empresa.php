<?php
/**
 * Empresa.php - Modelo para empresas
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class Empresa {
    /**
     * Crea la tabla de empresas
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS Empresa (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            razon_social TEXT NOT NULL,
            sector TEXT NOT NULL,
            persona_contacto TEXT NOT NULL,
            RIF TEXT NOT NULL UNIQUE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Crea una nueva empresa
     */
    public static function create($data) {
        $sql = "INSERT INTO Empresa (razon_social, sector, persona_contacto, RIF)
                VALUES (:razon_social, :sector, :persona_contacto, :RIF)";

        $params = [
            ':razon_social' => $data['razon_social'],
            ':sector' => $data['sector'],
            ':persona_contacto' => $data['persona_contacto'],
            ':RIF' => $data['RIF']
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Obtiene una empresa por ID
     */
    public static function getById($id) {
        $sql = "SELECT * FROM Empresa WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $id]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza una empresa
     */
    public static function update($id, $data) {
        $allowedFields = ['razon_social', 'sector', 'persona_contacto', 'RIF'];
        $updates = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE Empresa SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina una empresa
     */
    public static function delete($id) {
        // Primero eliminamos los usuarios asociados (implementación alternativa)
        $usuariosAsociados = UsuarioEmpresa::getUsuariosByEmpresa($id);
        foreach ($usuariosAsociados as $usuario) {
            Usuario::delete($usuario['id']);
        }
    
        // Luego eliminamos la empresa
        $sql = "DELETE FROM Empresa WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $id]);
    }

    /**
     * Obtiene todas las empresas
     */
    public static function getAll() {
        $sql = "SELECT * FROM Empresa";
        $result = Database::getInstance()->query($sql);
        $empresas = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $empresas[] = $row;
        }

        return $empresas;
    }

    /**
     * Busca empresas por RIF
     */
    public static function findByRif($rif) {
        $sql = "SELECT * FROM Empresa WHERE RIF = :RIF";
        $result = Database::getInstance()->preparedQuery($sql, [':RIF' => $rif]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }
}
?>