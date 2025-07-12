<?php
/**
 * Usuario.php - Modelo base para todos los usuarios
 */

require_once __DIR__ . '/Database.php';

class Usuario {
    /**
     * Crea la tabla 'usuario' si no existe
     */
    public static function createTable() {
        $sql = "
            CREATE TABLE IF NOT EXISTS usuario (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nombre_usuario TEXT UNIQUE NOT NULL,
                contraseña TEXT NOT NULL,
                correo TEXT UNIQUE NOT NULL,
                tipo_usuario TEXT NOT NULL
            )
        ";
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Inserta un nuevo usuario en la tabla
     * @param array $data Datos del usuario
     * @return bool Resultado de la operación
     */
    public static function insert($data) {
        $sql = "
            INSERT INTO usuario (nombre_usuario, contraseña, correo, tipo_usuario)
            VALUES (:nombre_usuario, :contraseña, :correo, :tipo_usuario)
        ";

        // Hashear la contraseña antes de guardar
        $data[':contraseña'] = password_hash($data[':contraseña'], PASSWORD_DEFAULT);

        return Database::getInstance()->preparedQuery($sql, $data);
    }

    /**
     * Busca un usuario por su nombre de usuario
     * @param string $username Nombre de usuario
     * @return SQLite3Result|false Resultado de la consulta
     */
    public static function findByUsername($username) {
        $sql = "SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario";
        return Database::getInstance()->preparedQuery($sql, [':nombre_usuario' => $username]);
    }

    /**
     * Verifica si las credenciales son válidas
     * @param string $username
     * @param string $password
     * @return array|null Datos del usuario si es válido, null si no
     */
    public static function validateCredentials($username, $password) {
        $result = self::findByUsername($username);
        $user = $result ? $result->fetchArray(SQLITE3_ASSOC) : null;

        if ($user && password_verify($password, $user['contraseña'])) {
            return $user;
        }

        return null;
    }

    /**
     * Busca un usuario por correo electrónico
     * @param string $correo
     * @return SQLite3Result|false
     */
    public static function findByEmail($correo) {
        $sql = "SELECT * FROM usuario WHERE correo = :correo";
        return Database::getInstance()->preparedQuery($sql, [':correo' => $correo]);
    }
}