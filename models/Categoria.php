<?php
/** Categoria.php - Modelo para categorías de ofertas laborales */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class Categoria {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS Categoria (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL UNIQUE
        )";
        return Database::getInstance()->execQuery($sql);
    }

    public static function create($nombre) {
        $sql = "INSERT INTO Categoria (nombre) VALUES (:nombre)";
        $db = Database::getInstance();
        if ($db->preparedQuery($sql, [':nombre' => $nombre])) {
            return $db->lastInsertId();
        }
        return false;
    }

    public static function getAll() {
        $sql = "SELECT * FROM Categoria";
        $result = Database::getInstance()->query($sql);
        $categorias = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $categorias[] = $row;
        }
        return $categorias;
    }

    public static function getById($id) {
        $sql = "SELECT * FROM Categoria WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $id]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    public static function delete($id) {
        $sql = "DELETE FROM Categoria WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $id]);
    }
}
?>