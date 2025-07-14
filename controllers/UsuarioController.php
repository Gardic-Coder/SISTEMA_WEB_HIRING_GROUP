<?php
require_once __DIR__ . '/../utils/config.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';

class UsuarioController {
    /**
     * Registra un nuevo usuario postulante
     */
    public static function registrarPostulante($data) {
        // Validar campos mínimos
        if (empty($data['nombre_usuario']) || empty($data['contraseña']) || empty($data['correo'])) {
            throw new Exception("Faltan datos obligatorios");
        }

        // Crear usuario
        $usuarioId = Usuario::create([
            'nombre_usuario' => $data['nombre_usuario'],
            'contraseña' => $data['contraseña'], // el modelo debe hashearla
            'correo' => $data['correo'],
            'tipo_usuario' => 'postulante'
        ]);

        if (!$usuarioId) {
            throw new Exception("Error al crear el usuario");
        }

        // Crear perfil de postulante
        UsuarioPostulante::add([
            'usuario_id' => $usuarioId,
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'cedula' => $data['cedula'],
            'estado_residencia' => $data['estado_residencia'],
            'ciudad_residencia' => $data['ciudad_residencia'],
            'contratado' => 0,
            'tipo_sangre' => $data['tipo_sangre'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'genero' => $data['genero']
        ]);

        return $usuarioId;
    }
}
?>