<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/UsuarioPostulante.php';

/**
 * Pruebas unitarias para la clase UsuarioPostulante
 */

echo "Pruebas de UsuarioPostulante:\n";

// Primero necesitamos un usuario base para el postulante
$usuarioId = null;

// Crear usuario base
try {
    Usuario::createTable();
    $usuarioId = Usuario::create([
        'nombre_usuario' => 'postulante_test',
        'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
        'correo' => 'postulante@test.com',
        'tipo_usuario' => 'postulante'
    ]);
    echo "Usuario base creado con ID: $usuarioId\n";
} catch (Exception $e) {
    echo "Error al crear usuario base: " . $e->getMessage() . "\n";
    exit;
}

// Prueba de creación de tabla
try {
    UsuarioPostulante::createTable();
    echo "Tabla de UsuarioPostulante creada correctamente.\n";
} catch (Exception $e) {
    echo "Error al crear la tabla UsuarioPostulante: " . $e->getMessage() . "\n";
}

// Prueba de inserción de postulante
try { 
    $data = [
        'usuario_id' => $usuarioId,
        'nombre' => 'Juan',
        'apellido' => 'Pérez',
        'cedula' => '12345678',
        'estado_residencia' => 'Distrito Capital',
        'ciudad_residencia' => 'Caracas',
        'contratado' => false,
        'tipo_sangre' => 'A+',
        'fecha_nacimiento' => '1990-05-15',
        'genero' => 'masculino'
    ];
    
    $result = UsuarioPostulante::add($data);
    if ($result) {
        echo "Postulante insertado correctamente.\n";
    } else {
        echo "No se pudo insertar el postulante.\n";
    }
} catch (Exception $e) {
    echo "Error al insertar postulante: " . $e->getMessage() . "\n";
}

// Prueba de obtención por ID de usuario
try { 
    $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
    if ($postulante) {
        echo "Postulante obtenido:\n";
        echo "Nombre: " . $postulante['nombre'] . " " . $postulante['apellido'] . "\n";
        echo "Cédula: " . $postulante['cedula'] . "\n";
        echo "Residencia: " . $postulante['ciudad_residencia'] . ", " . $postulante['estado_residencia'] . "\n";
    } else {
        echo "Postulante no encontrado.\n";
    }
} catch (Exception $e) {
    echo "Error al obtener postulante: " . $e->getMessage() . "\n";
}

// Prueba de búsqueda por cédula
try {
    $postulante = UsuarioPostulante::getByField('cedula', '12345678');
    if ($postulante) {
        echo "Postulante encontrado por cédula:\n";
        echo "ID: " . $postulante['usuario_id'] . "\n";
        echo "Nombre: " . $postulante['nombre'] . "\n";
    } else {
        echo "Postulante no encontrado por cédula.\n";
    }
} catch (Exception $e) {
    echo "Error al buscar postulante por cédula: " . $e->getMessage() . "\n";
}

// Prueba de búsqueda por correo (usando JOIN con Usuario)
try {
    $postulante = UsuarioPostulante::getByField('Usuario.correo', 'postulante@test.com');
    if ($postulante) {
        echo "Postulante encontrado por correo:\n";
        echo "Correo: " . $postulante['correo'] . "\n";
        echo "Tipo de usuario: " . $postulante['tipo_usuario'] . "\n";
    } else {
        echo "Postulante no encontrado por correo.\n";
    }
} catch (Exception $e) {
    echo "Error al buscar postulante por correo: " . $e->getMessage() . "\n";
}

// Prueba de actualización de postulante
try {
    $updated = UsuarioPostulante::update($usuarioId, [
        'nombre' => 'Juan Carlos',
        'ciudad_residencia' => 'Valencia',
        'contratado' => true
    ]);
    
    if ($updated) {
        echo "Postulante actualizado correctamente.\n";
        
        // Verificar los cambios
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
        if ($postulante) {
            echo "Datos actualizados:\n";
            echo "Nombre: " . $postulante['nombre'] . "\n";
            echo "Ciudad: " . $postulante['ciudad_residencia'] . "\n";
            echo "Contratado: " . ($postulante['contratado'] ? 'Sí' : 'No') . "\n";
        }
    } else {
        echo "No se pudo actualizar el postulante.\n";
    }
} catch (Exception $e) {    
    echo "Error al actualizar postulante: " . $e->getMessage() . "\n";
}

// Prueba de eliminación de postulante
try {
    $deleted = UsuarioPostulante::delete($usuarioId);
    if ($deleted) {
        echo "Postulante eliminado correctamente.\n";
        
        // Verificar que ya no existe
        $postulante = UsuarioPostulante::getByField('usuario_id', $usuarioId);
        if (!$postulante) {
            echo "Postulante ya no existe en la base de datos.\n";
        }
    } else {
        echo "No se pudo eliminar el postulante.\n";
    }
} catch (Exception $e) {
    echo "Error al eliminar postulante: " . $e->getMessage() . "\n";
}

// Limpieza final - eliminar usuario base
try {
    $deleted = Usuario::delete($usuarioId);
    if ($deleted) {
        echo "Usuario base eliminado correctamente.\n";
    } else {
        echo "No se pudo eliminar el usuario base.\n";
    }
} catch (Exception $e) {
    echo "Error al eliminar usuario base: " . $e->getMessage() . "\n";
}

?>