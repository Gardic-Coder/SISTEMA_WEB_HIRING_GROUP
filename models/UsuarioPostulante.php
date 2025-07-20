<?php
/**
 * UsuarioPostulante.php - Modelo para usuarios postulantes
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';

class UsuarioPostulante {
    /**
     * Crea la tabla UsuarioPostulante si no existe
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS UsuarioPostulante (
            usuario_id INTEGER PRIMARY KEY,
            nombre TEXT NOT NULL,
            apellido TEXT NOT NULL,
            cedula TEXT UNIQUE NOT NULL,
            estado_residencia TEXT NOT NULL,
            ciudad_residencia TEXT NOT NULL,
            contratado BOOLEAN DEFAULT 0,
            tipo_sangre TEXT CHECK(tipo_sangre IN ('A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-')),
            fecha_nacimiento DATE NOT NULL,
            genero TEXT CHECK(genero IN ('masculino', 'femenino', 'otro')),
            FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Inserta un nuevo usuario postulante
     * @param array $data Datos del usuario postulante
     * @return int|false ID del usuario insertado o false en caso de error
     */
    public static function add($data) {
        $sql = "INSERT INTO UsuarioPostulante 
                (usuario_id, nombre, apellido, cedula, estado_residencia, ciudad_residencia, 
                 contratado, tipo_sangre, fecha_nacimiento, genero) 
                VALUES (:usuario_id, :nombre, :apellido, :cedula, :estado_residencia, 
                        :ciudad_residencia, :contratado, :tipo_sangre, :fecha_nacimiento, :genero)";
        
        $params = [
            ':usuario_id' => $data['usuario_id'],
            ':nombre' => $data['nombre'],
            ':apellido' => $data['apellido'],
            ':cedula' => $data['cedula'],
            ':estado_residencia' => $data['estado_residencia'],
            ':ciudad_residencia' => $data['ciudad_residencia'],
            ':contratado' => $data['contratado'] ?? 0,
            ':tipo_sangre' => $data['tipo_sangre'] ?? null,
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':genero' => $data['genero']
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Busca un usuario postulante por cualquier campo, incluyendo campos de Usuario (JOIN).
     * @param string $campo Nombre del campo por el que buscar (puede ser de Usuario o UsuarioPostulante)
     * @param mixed $valor Valor a buscar
     * @return array|null
     */
    public static function getByField($campo, $valor) {
        // Lista de campos permitidos para evitar inyección SQL
        $camposPermitidos = [
            'Usuario.correo', 'Usuario.tipo_usuario', 'Usuario.nombre_usuario',
            'UsuarioPostulante.nombre', 'UsuarioPostulante.apellido','UsuarioPostulante.cedula', 
            'UsuarioPostulante.estado_residencia', 'UsuarioPostulante.ciudad_residencia', 'UsuarioPostulante.contratado', 'UsuarioPostulante.tipo_sangre', 'UsuarioPostulante.fecha_nacimiento',
            'UsuarioPostulante.genero', 'UsuarioPostulante.usuario_id'
        ];

        // Si el campo no tiene prefijo, asumimos UsuarioPostulante
        if (strpos($campo, '.') === false) {
            $campo = "UsuarioPostulante.$campo";
        }

        if (!in_array($campo, $camposPermitidos)) {
            return null;
        }

        $sql = "SELECT Usuario.*, UsuarioPostulante.*
                FROM UsuarioPostulante
                INNER JOIN Usuario ON Usuario.id = UsuarioPostulante.usuario_id
                WHERE $campo = :valor
                LIMIT 1";
        $result = Database::getInstance()->preparedQuery($sql, [':valor' => $valor]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Actualiza los datos de un usuario postulante
     * @param int $usuarioId ID del usuario postulante a actualizar
     * @param array $data Datos a actualizar (solo campos permitidos)
     * @return bool True si la actualización fue exitosa, false en caso contrario
     */
    public static function update($usuarioId, $data) {
        $allowedFields = ['nombre', 'apellido', 'cedula', 'estado_residencia', 'ciudad_residencia', 
                         'contratado', 'tipo_sangre', 'fecha_nacimiento', 'genero'];
        $updates = [];
        $params = [':usuario_id' => $usuarioId];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE UsuarioPostulante SET " . implode(', ', $updates) . " WHERE usuario_id = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina un usuario postulante por su ID
     * @param int $usuarioId ID del usuario postulante a eliminar
     * @return bool True si la eliminación fue exitosa, false en caso contrario
     */
    public static function delete($usuarioId) {
        $sql = "DELETE FROM UsuarioPostulante WHERE usuario_id = :usuario_id";
        return Database::getInstance()->preparedQuery($sql, [':usuario_id' => $usuarioId]);
    }
}
?>