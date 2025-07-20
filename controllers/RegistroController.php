<?php
// controllers/RegistroController.php

class RegistroController {
    public function showRegistroForm() {
        // Si ya está logueado, redirigir al dashboard
        if (Auth::check()) {
            header('Location: ' . APP_URL . '/dashboard');
            exit;
        }
        
        require VIEWS_DIR . 'registro/formulario.php';
    }

    public function registrarPostulante() {
        try {
            // Validar datos del formulario
            $this->validarDatosRegistro($_POST);
            
            // Crear el usuario
            $usuarioId = $this->crearUsuario($_POST);
            
            // Crear el postulante asociado
            $postulanteId = $this->crearPostulante($usuarioId, $_POST);
            
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
        $required = ['username', 'email', 'password', 'confirm_password', 'nombres', 'apellidos'];
        
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
        
        // Verificar si el usuario ya existe
        if (Usuario::findBy('nombre_usuario', $data['username'])) {
            throw new Exception("El nombre de usuario ya está registrado");
        }
        
        if (Usuario::findBy('correo', $data['email'])) {
            throw new Exception("El email ya está registrado");
        }
    }

    private function crearUsuario($data) {
        return Usuario::create([
            'nombre_usuario' => $_POST['username'],
            'contraseña' => $_POST['password'],
            'correo' => $_POST['email'],
            'tipo_usuario' => 'postulante'
        ]);
    }

    private function crearPostulante($usuarioId, $data) {
        return UsuarioPostulante::add([
            'usuario_id' => $usuarioId,
            'nombres' => $data['nombres'],
            'apellidos' => $data['apellidos'],
            'fecha_nacimiento' => $data['fecha_nacimiento'] ?? null,
            'telefono' => $data['telefono'] ?? null
        ]);
    }
}