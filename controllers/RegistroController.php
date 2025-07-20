<?php
// controllers/RegistroController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'Telefono.php';


class RegistroController {
    public function showRegistroPostulante() {
        // Si ya está logueado, redirigir al dashboard
        if (Auth::check()) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
        
        require VIEWS_DIR . 'auth/registroPostulante.php';
    }

    public function registrarPostulante() {
        try {
            // Validar datos del formulario
            $this->validarDatosRegistro($_POST);
            
            // Crear el usuario
            $usuarioId = $this->crearUsuario($_POST);

            if (!$usuarioId) {
                throw new Exception("Error al crear el usuario principal");
            }
            
            // Crear el postulante asociado
            $postulanteId = $this->crearPostulante($usuarioId, $_POST);

            if (!$postulanteId) {
                // Si falla, eliminar el usuario creado para mantener la integridad
                Usuario::delete($usuarioId);
                throw new Exception("Error al crear el perfil de postulante");
            }

            // Registrar teléfono si se recibió
            if (!empty($_POST['telefono'])) {
                Telefono::add($usuarioId, $_POST['telefono']);
            }

            // Iniciar sesión automáticamente
            $usuario = Usuario::findBy('id', $usuarioId);
            Auth::login([
                'id' => $usuario['id'],
                'nombre_usuario' => $usuario['nombre_usuario'],
                'correo' => $usuario['correo'],
                'tipo_usuario' => $usuario['tipo_usuario']
            ]);
            
            // Redirigir al dashboard
            header('Location: ' . APP_URL . '/dashboard');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error_registro'] = $e->getMessage();
            $_SESSION['form_data'] = $_POST; // Guardar datos para repoblar formulario
            header('Location: ' . APP_URL . '/registro/postulante');
            exit;
        }
    }

    private function validarDatosRegistro($data) {
        $required = [
            'username', 'email', 'password', 'confirm_password', 
            'nombres', 'apellidos', 'cedula', 
            'estado_residencia', 'ciudad_residencia', 'fecha_nacimiento'
        ];
        
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("El campo " . ucfirst($field) . " es obligatorio");
            }
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            throw new Exception("Las contraseñas no coinciden");
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El email no es válido");
        }
        
        // Validar formato de fecha (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['fecha_nacimiento'])) {
            throw new Exception("Formato de fecha inválido. Use YYYY-MM-DD");
        }

        // Calcular edad
        $fechaNacimiento = new DateTime($data['fecha_nacimiento']);
        $hoy = new DateTime();
        $edad = $hoy->diff($fechaNacimiento)->y;

        if ($edad < 18) {
            throw new Exception("Debe ser mayor de edad para registrarse");
        }

        
        // Verificar si el usuario ya existe
        if (Usuario::findBy('nombre_usuario', $data['username'])) {
            throw new Exception("El nombre de usuario ya está registrado");
        }
        
        if (Usuario::findBy('correo', $data['email'])) {
            throw new Exception("El email ya está registrado");
        }
        
        // Verificar cédula única
        if (UsuarioPostulante::getByField('cedula', $data['cedula'])) {
            throw new Exception("La cédula ya está registrada");
        }

        if (!preg_match('/^[A-Za-zÁ-ú\s]{3,30}$/u', $data['nombres'])) {
            throw new Exception("El nombre no tiene un formato válido");
        }
        if (!preg_match('/^[A-Za-zÁ-ú\s]{3,30}$/u', $data['apellidos'])) {
            throw new Exception("El apellido no tiene un formato válido");
        }

        if (!preg_match('/^[VE]-\d{2}.\d{3}.\d{3}$/', $data['cedula'])) {
            throw new Exception("La cédula no tiene el formato correcto");
        }

    }

    private function crearUsuario($data) {
        return Usuario::create([
            'nombre_usuario' => $data['username'],
            'contraseña' => $data['password'],
            'correo' => $data['email'],
            'tipo_usuario' => 'postulante'
        ]);
    }

    private function crearPostulante($usuarioId, $data) {
        return UsuarioPostulante::add([
            'usuario_id' => $usuarioId,
            'nombre' => $data['nombres'],
            'apellido' => $data['apellidos'],
            'cedula' => $data['cedula'],
            'estado_residencia' => $data['estado_residencia'],
            'ciudad_residencia' => $data['ciudad_residencia'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'genero' => $data['genero'],
            'tipo_sangre' => $data['tipo_sangre'] ?? null
        ]);
    }
}