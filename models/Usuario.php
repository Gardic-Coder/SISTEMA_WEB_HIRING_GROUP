<?php
/**
 * Usuario.php - Modelo completo para usuarios con manejo seguro de fotos de perfil
 */

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Database.php';
require_once IMAGE_HANDLER_PATH;

class Usuario {
    /**
     * Crea la tabla de usuarios en la base de datos
     */
    public static function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS usuario (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre_usuario TEXT UNIQUE NOT NULL,
            contraseña TEXT NOT NULL,
            correo TEXT UNIQUE NOT NULL,
            tipo_usuario TEXT CHECK(tipo_usuario IN ('administrador', 'empresa', 'postulante', 'hiring_group')) NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            foto_perfil TEXT,
            foto_perfil_pequena TEXT
        )";
        
        return Database::getInstance()->execQuery($sql);
    }

    /**
     * Actualiza la foto de perfil de manera segura
     */
    public static function updateProfileImage($userId, $imageFile) {
        // 1. Primero validar la nueva imagen
        $newImageData = ImageHandler::validateAndPrepare($imageFile);
        if (!$newImageData) {
            throw new Exception("La imagen no es válida");
        }

        // 2. Obtener usuario actual
        $user = self::getById($userId);
        if (!$user) {
            throw new Exception("Usuario no encontrado");
        }

        $oldImage = $user['foto_perfil'];
        $backupImage = null;

        try {
            // 3. Crear backup temporal de la imagen actual
            if ($oldImage) {
                $backupImage = ImageHandler::createTempCopy($oldImage);
            }

            // 4. Guardar la nueva imagen
            $savedImage = ImageHandler::saveProfileImage($imageFile);
            if (!$savedImage) {
                throw new Exception("Error al guardar la nueva imagen");
            }

            // 5. Actualizar la base de datos
            $updateSuccess = self::update($userId, [
                'foto_perfil' => $savedImage['original'],
                'foto_perfil_pequena' => $savedImage['versions']['small'] ?? $savedImage['original']
            ]);

            if (!$updateSuccess) {
                throw new Exception("Error al actualizar la base de datos");
            }

            // 6. Si todo sale bien, eliminar la imagen anterior y el backup
            if ($oldImage) {
                ImageHandler::deleteProfileImage($oldImage);
                if ($backupImage) {
                    unlink($backupImage);
                }
            }

            return $savedImage['urls'];

        } catch (Exception $e) {
            // Revertir cambios en caso de error
            if (isset($savedImage)) {
                ImageHandler::deleteProfileImage($savedImage['original']);
            }

            // Restaurar imagen anterior si existía
            if ($backupImage && file_exists($backupImage)) {
                $restored = ImageHandler::restoreFromBackup($backupImage, $oldImage);
                if (!$restored) {
                    error_log("Error al restaurar imagen de perfil para usuario $userId");
                }
            }

            throw new Exception("Error al actualizar la foto de perfil: " . $e->getMessage());
        }
    }

    /**
     * Elimina la foto de perfil solo si se puede garantizar la integridad
     */
    public static function removeProfileImage($userId) {
        $user = self::getById($userId);
        if (!$user || empty($user['foto_perfil'])) {
            return true; // No hay imagen que eliminar
        }

        try {
            // Primero actualizar la BD para marcar como eliminado
            $updateSuccess = self::update($userId, [
                'foto_perfil' => null,
                'foto_perfil_pequena' => null
            ]);

            if (!$updateSuccess) {
                throw new Exception("Error al actualizar la base de datos");
            }

            // Luego eliminar los archivos físicos
            if (!ImageHandler::deleteProfileImage($user['foto_perfil'])) {
                error_log("Advertencia: La foto de perfil fue eliminada de la BD pero no de los archivos para usuario $userId");
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Error al eliminar la foto de perfil: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un usuario por ID
     */
    public static function getById($id) {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $result = Database::getInstance()->preparedQuery($sql, [':id' => $id]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Crea un nuevo usuario
     */
    public static function create($userData) {
        $sql = "INSERT INTO usuario (nombre_usuario, contraseña, correo, tipo_usuario)
                VALUES (:nombre_usuario, :contraseña, :correo, :tipo_usuario)";

        $params = [
            ':nombre_usuario' => $userData['nombre_usuario'],
            ':contraseña' => password_hash($userData['contraseña'], PASSWORD_DEFAULT),
            ':correo' => $userData['correo'],
            ':tipo_usuario' => $userData['tipo_usuario']
        ];

        $db = Database::getInstance();
        if ($db->preparedQuery($sql, $params)) {
            return $db->lastInsertId();
        }
        return false;
    }

    /**
     * Actualiza datos del usuario
     */
    public static function update($id, $data) {
        $allowedFields = ['nombre_usuario', 'contraseña', 'correo', 'tipo_usuario', 'foto_perfil', 'foto_perfil_pequena'];
        $updates = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $updates[] = "$key = :$key";
                $params[":$key"] = ($key === 'contraseña') 
                    ? password_hash($value, PASSWORD_DEFAULT)
                    : $value;
            }
        }

        if (empty($updates)) return false;

        $sql = "UPDATE usuario SET " . implode(', ', $updates) . " WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, $params);
    }

    /**
     * Elimina un usuario (incluyendo su foto de perfil)
     */
    public static function delete($id) {
        $user = self::getById($id);
        if (!$user) return false;

        // Eliminar foto de perfil si existe
        if (!empty($user['foto_perfil'])) {
            try {
                ImageHandler::deleteProfileImage($user['foto_perfil']);
            } catch (Exception $e) {
                error_log("Error al eliminar foto de perfil del usuario $id: " . $e->getMessage());
            }
        }

        $sql = "DELETE FROM usuario WHERE id = :id";
        return Database::getInstance()->preparedQuery($sql, [':id' => $id]);
    }

    /**
     * Busca un usuario por cualquier campo (nombre_usuario, correo, id, etc.)
     * @param string $field El campo por el que buscar (ej: 'nombre_usuario', 'correo', 'id')
     * @param mixed $value El valor a buscar
     * @return array|null
     */
    public static function findBy($field, $value) {
        $allowedFields = ['id', 'nombre_usuario', 'correo'];
        if (!in_array($field, $allowedFields)) {
            throw new InvalidArgumentException("Campo de búsqueda no permitido");
        }
        $sql = "SELECT * FROM usuario WHERE $field = :value";
        $result = Database::getInstance()->preparedQuery($sql, [':value' => $value]);
        return $result ? $result->fetchArray(SQLITE3_ASSOC) : null;
    }

    /**
     * Verifica credenciales de usuario
     */
    public static function validateCredentials($username, $password) {
        $user = self::findByUsername($username);
        if ($user && password_verify($password, $user['contraseña'])) {
            return $user;
        }
        return false;
    }

    /**
     * Obtiene todos los usuarios (opcionalmente filtrados por tipo)
     */
    public static function getAll($tipo = null) {
        $sql = "SELECT * FROM usuario";
        $params = [];

        if ($tipo) {
            $sql .= " WHERE tipo_usuario = :tipo";
            $params[':tipo'] = $tipo;
        }

        $result = Database::getInstance()->preparedQuery($sql, $params);
        $users = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $users[] = $row;
        }

        return $users;
    }
}
?>