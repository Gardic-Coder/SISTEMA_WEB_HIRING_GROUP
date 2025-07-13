<?php
require_once __DIR__ . '/../models/Usuario.php';
/**
 * Pruebas unitarias para la clase Usuario
 */

echo "Pruebas de Usuario:\n";
// Prueba de creación de usuario
try {
    Usuario::createTable();
    echo "Tabla de usuarios creada correctamente.\n";
} catch (Exception $e) {
    echo "Error al crear la tabla de usuarios: " . $e->getMessage() . "\n";
}
// Prueba de inserción de usuario
try { 
    $userId = Usuario::insert([
        'nombre_usuario' => 'testuser',
        'contraseña' => password_hash('password123', PASSWORD_BCRYPT),
        'correo' => 'testuser@email.com',
        'tipo_usuario' => 'administrador']);
    echo "Usuario insertado con ID: $userId\n";
} catch (Exception $e) {
    echo "Error al insertar usuario: " . $e->getMessage() . "\n";
}
// Prueba de obtención de usuario
try { 
    $user = Usuario::getById($userId);
    if ($user) {
        echo "Usuario obtenido: " . print_r($user, true) . "\n";
    } else {
        echo "Usuario no encontrado.\n";
    }
} catch (Exception $e) {
    echo "Error al obtener usuario: " . $e->getMessage() . "\n";
}
// Prueba de actualización de usuario
try {
    $updated = Usuario::update($userId, [
        'nombre_usuario' => 'updateduser',
        'contraseña' => 'newpassword123']);
    if ($updated) {
        echo "Usuario actualizado correctamente.\n";
    } else {
        echo "No se pudo actualizar el usuario.\n";
    }
} catch (Exception $e) {    
    echo "Error al actualizar usuario: " . $e->getMessage() . "\n";
}
// Prueba buscar usuario por nombre
try {
    $user = Usuario::findByUsername('updateduser');
    if ($user) {
        echo "Usuario encontrado por nombre: " . print_r($user, true) . "\n";
    } else {
        echo "Usuario no encontrado por nombre.\n";
    }
} catch (Exception $e) {
    echo "Error al buscar usuario por nombre: " . $e->getMessage() . "\n";
}
// Prueba buscar usuario por correo
try {
    $user = Usuario::getByEmail('testuser@email.com');
    if ($user) {    
        echo "Usuario encontrado por correo: " . print_r($user, true) . "\n";
    } else {
        echo "Usuario no encontrado por correo.\n";
    }
} catch (Exception $e) {
    echo "Error al buscar usuario por correo: " . $e->getMessage() . "\n";
}
// Prueba de validación de credenciales
try {
    $validUser = Usuario::validateCredentials('updateduser', 'newpassword123');
    if ($validUser) {
        echo "Credenciales válidas para usuario: " . print_r($validUser, true) . "\n";
    } else {
        echo "Credenciales inválidas.\n";
    }
} catch (Exception $e) {
    echo "Error al validar credenciales: " . $e->getMessage() . "\n";
}
// Prueba de obtención de todos los usuarios
try {
    $users = Usuario::getAll();
    if ($users) {
        echo "Usuarios obtenidos: " . print_r($users, true) . "\n";
    } else {
        echo "No hay usuarios registrados.\n";
    }
} catch (Exception $e) {
    echo "Error al obtener todos los usuarios: " . $e->getMessage() . "\n";
}
// Prueba de eliminación de usuario
try {
    $deleted = Usuario::delete($userId);
    if ($deleted) {
        echo "Usuario eliminado correctamente.\n";
    } else {
        echo "No se pudo eliminar el usuario.\n";
    }
} catch (Exception $e) {
    echo "Error al eliminar usuario: " . $e->getMessage() . "\n";
}


?>