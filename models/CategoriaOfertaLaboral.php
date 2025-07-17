<?php
/** CategoriaOfertaLaboral.php - Relación entre categorías y ofertas laborales */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class CategoriaOfertaLaboral {
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS CategoriaOfertaLaboral (
            categoria_id INTEGER NOT NULL,
            oferta_id INTEGER NOT NULL,
            PRIMARY KEY (categoria_id, oferta_id),
            FOREIGN KEY (categoria_id) REFERENCES Categoria(id) ON DELETE CASCADE,
            FOREIGN KEY (oferta_id) REFERENCES OfertaLaboral(id) ON DELETE CASCADE
        )";
        return Database::getInstance()->execQuery($sql);
    }

    public static function add($categoriaId, $ofertaId) {
        $sql = "INSERT INTO CategoriaOfertaLaboral (categoria_id, oferta_id)
                VALUES (:categoria_id, :oferta_id)";
        return Database::getInstance()->preparedQuery($sql, [
            ':categoria_id' => $categoriaId,
            ':oferta_id' => $ofertaId
        ]);
    }

    public static function getCategoriasByOferta($ofertaId) {
        $sql = "SELECT c.* FROM CategoriaOfertaLaboral col
                JOIN Categoria c ON col.categoria_id = c.id
                WHERE col.oferta_id = :oferta_id";
        $result = Database::getInstance()->preparedQuery($sql, [':oferta_id' => $ofertaId]);
        $categorias = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $categorias[] = $row;
        }
        return $categorias;
    }

    public static function getOfertasByCategoria($categoriaId) {
        $sql = "SELECT o.* FROM CategoriaOfertaLaboral col
                JOIN OfertaLaboral o ON col.oferta_id = o.id
                WHERE col.categoria_id = :categoria_id";
        $result = Database::getInstance()->preparedQuery($sql, [':categoria_id' => $categoriaId]);
        $ofertas = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ofertas[] = $row;
        }
        return $ofertas;
    }

    public static function deleteByOferta($ofertaId) {
        $sql = "DELETE FROM CategoriaOfertaLaboral WHERE oferta_id = :oferta_id";
        return Database::getInstance()->preparedQuery($sql, [':oferta_id' => $ofertaId]);
    }

    public static function deleteByCategoria($categoriaId) {
        $sql = "DELETE FROM CategoriaOfertaLaboral WHERE categoria_id = :categoria_id";
        return Database::getInstance()->preparedQuery($sql, [':categoria_id' => $categoriaId]);
    }
}
?>