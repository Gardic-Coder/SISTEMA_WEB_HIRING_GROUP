<?php
/**
 * db.php - Manejo centralizado de la base de datos SQLite
 */

class Database {
    private static $instance = null;
    private $db;
    private $db_file = 'database/mi_app.sqlite';
    
    // Privado para evitar instanciación directa
    private function __construct() {
        $this->connect();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    private function connect() {
        try {
            // Crear directorio si no existe
            if (!file_exists('database')) {
                mkdir('database', 0755, true);
            }
            
            $this->db = new SQLite3($this->db_file);
            $this->db->enableExceptions(true);
        } catch (Exception $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
    
    /**
     * Ejecuta una consulta SQL
     * @param string $query Consulta SQL a ejecutar
     * @return SQLite3Result|bool Resultado de la consulta
     */
    public function execQuery($query) {
        try {
            return $this->db->exec($query);
        } catch (Exception $e) {
            error_log("Error en consulta SQL: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Prepara y ejecuta una consulta con parámetros
     * @param string $query Consulta SQL con placeholders
     * @param array $params Array asociativo de parámetros
     * @return SQLite3Stmt|false Declaración preparada o false en error
     */
    public function preparedQuery($query, $params = []) {
        try {
            $stmt = $this->db->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error en consulta preparada: " . $e->getMessage());
            return false;
        }
    }
    
    // Evitar clonación
    private function __clone() {}
    
    // Cerrar conexión automáticamente al destruir
    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}

/**
 * Función global para facilitar el acceso a la base de datos
 * @return Database Instancia singleton de la base de datos
 */
function db() {
    return Database::getInstance();
}
?>