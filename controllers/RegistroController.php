<?php
// controllers/RegistroController.php

require_once __DIR__ . '/../utils/config.php';
require_once CORE_DIR . 'Auth.php';
require_once MODELS_DIR . 'Usuario.php';
require_once MODELS_DIR . 'Telefono.php';
require_once MODELS_DIR . 'UsuarioPostulante.php';
require_once MODELS_DIR . 'Contratacion.php';
require_once MODELS_DIR . 'ReporteActividad.php';
require_once UTILS_DIR . 'DocumentHandler.php';


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

    public function mostrarEdicionPostulante() {
        // Verificar si el usuario está logueado
        if (!Auth::check()) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }

        $usuarioId = Auth::user()['id'];
        $usuario = Usuario::getById($usuarioId);
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
        $telefonos = Telefono::getByUsuario($usuarioId);
        $cvUrl = $postulante['cv_url'] ?? null;


        require VIEWS_DIR . 'auth/postulante/edicion.php';
    }

    public function actualizarPerfilGeneral() {
        $this->verificarAutenticacion();

        $usuarioId = Auth::user()['id'];
        $tipoUsuario = Usuario::getById($usuarioId)['tipo_usuario'];
        $data = $_POST;
        $cambios = [];

        // Común a todos los usuarios
        $cambios = $this->actualizarDatosUsuario($usuarioId, $data, $cambios);
        $cambios = $this->actualizarTelefono($usuarioId, $data, $cambios);

        // Según tipo de usuario
        switch ($tipoUsuario) {
            case 'postulante':
            case 'contratado':
                $cambios = $this->actualizarDatosPostulante($usuarioId, $data, $cambios);
                $cambios = $this->gestionarCurriculum($usuarioId, $cambios);
                break;

            case 'empresa':
                $cambios = $this->actualizarDatosEmpresa($usuarioId, $data, $cambios);
                // Puedes agregar lógica para cargar documentos como RIF o perfil empresarial
                break;

            case 'administrador':
            case 'hiring_group':
                $cambios = $this->actualizarDatosAdministrador($usuarioId, $data, $cambios);
                break;

            default:
                $_SESSION['error'] = "Tipo de usuario no reconocido para actualización";
                header('Location: ' . APP_URL . '/dashboard');
                exit;
    }

    // Auditoría si hubo cambios
    $this->registrarActividad($usuarioId, $cambios);

    $_SESSION['success'] = "Perfil actualizado correctamente";
    header('Location: ' . APP_URL . '/dashboard');
    exit;
}


    // ======= FUNCIONES AUXILIARES =======

    private function verificarAutenticacion() {
        if (!Auth::check()) {
            header('Location: ' . APP_URL . '/login');
            exit;
        }
    }

    private function actualizarDatosUsuario($usuarioId, $data, array $cambios) {
        $usuario = Usuario::getById($usuarioId);
        $updateUsuario = [];

        // Actualizar email si es diferente
        if (!empty($data['email']) && $data['email'] !== $usuario['correo']) {
            $updateUsuario['correo'] = $data['email'];
            $cambios[] = "Usuario: correo";
        }

        // Actualizar nombre de usuario si es diferente
        if (!empty($data['username']) && $data['username'] !== $usuario['nombre_usuario']) {
            $updateUsuario['nombre_usuario'] = $data['username'];
            $cambios[] = "Usuario: nombre_usuario";
        }

        // Cambio de contraseña
        if (!empty($data['actual_password']) && !empty($data['new_password']) && !empty($data['confirm_password'])) {
            $this->validarCambioContrasena($usuario, $data); // Asegura que todo sea válido
            $updateUsuario['contraseña'] = $data['new_password']; // En texto plano
            $cambios[] = "Usuario: contraseña";
        }

        if (!empty($updateUsuario)) {
            Usuario::update($usuarioId, $updateUsuario);
        }

        return $cambios;
    }

    private function validarCambioContrasena($usuario, $data) {
        if (!password_verify($data['actual_password'], $usuario['contraseña'])) {
            $_SESSION['error'] = "La contraseña actual no es válida";
            header('Location: ' . APP_URL . '/dashboard/contratado');
            exit;
        }
        if ($data['new_password'] !== $data['confirm_password']) {
            $_SESSION['error'] = "Las nuevas contraseñas no coinciden";
            header('Location: ' . APP_URL . '/dashboard/contratado');
            exit;
        }
    }

    private function actualizarTelefono($usuarioId, $data, array $cambios) {
        if (!empty($data['telefono'])) {
            $telefonos = Telefono::getByUsuario($usuarioId);
            if (!empty($telefonos)) {
                $telefonoId = $telefonos[0]['ID'];
                Telefono::update($telefonoId, $data['telefono']);
            } else {
                Telefono::add($usuarioId, $data['telefono']);
            }
            $cambios[] = "Telefono: teléfono";
        }
        return $cambios;
    }

    private function actualizarDatosPostulante($usuarioId, $data, array $cambios) {
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
        $updatePostulante = [];

        $campos = [
            'nombre' => 'nombres',
            'apellido' => 'apellidos',
            'cedula' => 'cedula',
            'genero' => 'genero',
            'fecha_nacimiento' => 'fecha_nacimiento',
            'tipo_sangre' => 'tipo_sangre',
            'estado_residencia' => 'estado_residencia',
            'ciudad_residencia' => 'ciudad_residencia'
        ];

        foreach ($campos as $modelo => $form) {
            if (!empty($data[$form]) && $data[$form] !== $postulante[$modelo]) {
                $updatePostulante[$modelo] = $data[$form];
                $cambios[] = "Postulante: $modelo";
            }
        }

        $this->validarEstadoCiudad($data);

        if (!empty($updatePostulante)) {
            UsuarioPostulante::update($usuarioId, $updatePostulante);
        }

        return $cambios;
    }

    private function validarEstadoCiudad($data) {
        if (!empty($data['estado_residencia']) && empty($data['ciudad_residencia'])) {
            $_SESSION['error'] = "Debe seleccionar una ciudad si cambia el estado.";
            header('Location: ' . APP_URL . '/dashboard/contratado');
            exit;
        }
    }

    private function gestionarCurriculum($usuarioId, array $cambios) {
        if (isset($_FILES['curriculum']) && $_FILES['curriculum']['error'] === UPLOAD_ERR_OK) {
            try {
                $documentHandler = new DocumentHandler();

                // Eliminar CV anterior
                $this->eliminarCurriculumAnterior($usuarioId, $documentHandler, $cambios);

                // Subir nuevo documento
                $cvInfo = $documentHandler->uploadDocument($usuarioId, $_FILES['curriculum'], 'curriculum');

                // Guardar ruta del nuevo CV en la base
                UsuarioPostulante::actualizarCV($usuarioId, $cvInfo['url_relativa']);

                $cambios[] = "Archivo subido: CV.pdf";

            } catch (Exception $e) {
                $_SESSION['error'] = "Error al subir el currículum: " . $e->getMessage();
                header('Location: ' . APP_URL . '/dashboard/contratado');
                exit;
            }
        }
        return $cambios;
    }

    private function eliminarCurriculumAnterior($usuarioId, $documentHandler, &$cambios) {
        $documentosActuales = $documentHandler->listUserDocuments($usuarioId);
        foreach ($documentosActuales as $doc) {
            if ($doc['tipo'] === 'curriculum') {
                $documentHandler->deleteDocument($usuarioId, $doc['nombre'], 'curriculum');

                // Opcional: limpiar referencia en BD
                UsuarioPostulante::actualizarCV($usuarioId, null);

                $cambios[] = "Archivo eliminado: CV anterior";
                break;
            }
        }
    }

    private function registrarActividad($usuarioId, $cambios) {
        if (!empty($cambios)) {
            ReporteActividad::add([
                'usuario_id' => $usuarioId,
                'accion' => 'Actualización de perfil',
                'entidad_afectada' => implode(', ', $cambios)
            ]);
        }
    }

}