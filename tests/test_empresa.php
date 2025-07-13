<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/UsuarioEmpresa.php';
require_once __DIR__ . '/../models/Usuario.php';

/**
 * Pruebas para los modelos Empresa y UsuarioEmpresa
 */

echo "=== PRUEBAS EMPRESA Y USUARIOEMPRESA ===\n";

// Crear tablas
try {
    Usuario::createTable();
    Empresa::createTable();
    UsuarioEmpresa::createTable();
    echo "Tablas creadas correctamente.\n";
} catch (Exception $e) {
    die("Error al crear tablas: " . $e->getMessage());
}

// Prueba Empresa CRUD
$empresaId = null;
try {
    // Create
    $empresaId = Empresa::create([
        'razon_social' => 'Tech Solutions SA',
        'sector' => 'Tecnología',
        'persona_contacto' => 'Juan Pérez',
        'RIF' => 'J-123456789'
    ]);
    echo "Empresa creada con ID: $empresaId\n";
    
    // Read
    $empresa = Empresa::getById($empresaId);
    echo "Empresa obtenida: " . print_r($empresa, true) . "\n";
    
    // Update
    $updated = Empresa::update($empresaId, [
        'persona_contacto' => 'María González',
        'sector' => 'TI'
    ]);
    echo "Empresa actualizada: " . ($updated ? "✓" : "✗") . "\n";
    
    // Verificar update
    $empresaUpdated = Empresa::getById($empresaId);
    echo "Datos actualizados: " . print_r($empresaUpdated, true) . "\n";
    
} catch (Exception $e) {
    echo "Error en CRUD Empresa: " . $e->getMessage() . "\n";
}

// Prueba UsuarioEmpresa
$usuarioId = null;
try {
    // Crear un usuario de prueba
    $usuarioId = Usuario::create([
        'nombre_usuario' => 'empresa_test',
        'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
        'correo' => 'empresa_test@example.com',
        'tipo_usuario' => 'empresa'
    ]);
    echo "Usuario de prueba creado con ID: $usuarioId\n";
    
    // Asociar usuario a empresa
    $associated = UsuarioEmpresa::associate($usuarioId, $empresaId);
    echo "Usuario asociado a empresa: " . ($associated ? "✓" : "✗") . "\n";
    
    // Verificar asociación
    $empresasUsuario = UsuarioEmpresa::getEmpresaByUsuario($usuarioId);
    echo "Empresa de usuario: " . print_r($empresasUsuario, true) . "\n";
    
    $usuariosEmpresa = UsuarioEmpresa::getUsuariosByEmpresa($empresaId);
    echo "Usuarios de la empresa: " . print_r($usuariosEmpresa, true) . "\n";
    
} catch (Exception $e) {
    echo "Error en UsuarioEmpresa: " . $e->getMessage() . "\n";
}

// Prueba de asociación única
try {
    // Intentar asociar el mismo usuario a otra empresa
    $empresaId2 = Empresa::create([
        'razon_social' => 'Otra Empresa',
        'sector' => 'Consultoría',
        'persona_contacto' => 'Ana López',
        'RIF' => 'J-987654321'
    ]);
    
    echo "\nProbando asociación única...\n";
    
    // Esto debería fallar
    try {
        $associatedAgain = UsuarioEmpresa::associate($usuarioId, $empresaId2);
        echo "✗ Se permitió asociar a segunda empresa (no debería)\n";
    } catch (Exception $e) {
        echo "✓ Correctamente evitó asociación duplicada: " . $e->getMessage() . "\n";
    }
    
    // Probar actualización de asociación
    $updated = UsuarioEmpresa::updateAssociation($usuarioId, $empresaId2);
    echo "Actualización de asociación: " . ($updated ? "✓" : "✗") . "\n";
    
    // Verificar nueva asociación
    $empresaActual = UsuarioEmpresa::getEmpresaByUsuario($usuarioId);
    echo "Nueva empresa asociada: " . $empresaActual['razon_social'] . "\n";
    
    // Limpieza
    Empresa::delete($empresaId2);
    
} catch (Exception $e) {
    echo "Error en pruebas de asociación única: " . $e->getMessage() . "\n";
}

// Desasociar
    $disassociated = UsuarioEmpresa::disassociate($usuarioId, $empresaId);
    echo "Usuario desasociado: " . ($disassociated ? "✓" : "✗") . "\n";

// Limpieza
try {
    if ($usuarioId) {
        Usuario::delete($usuarioId);
    }
    if ($empresaId) {
        Empresa::delete($empresaId);
    }
    echo "Datos de prueba eliminados.\n";
} catch (Exception $e) {
    echo "Error al limpiar: " . $e->getMessage() . "\n";
}

// Prueba de eliminación en cascada
try {
    echo "\n=== PRUEBA ELIMINACIÓN EN CASCADA ===\n";
    
    // Crear empresa de prueba
    $empresaTestId = Empresa::create([
        'razon_social' => 'Empresa a Eliminar',
        'sector' => 'Pruebas',
        'persona_contacto' => 'Test User',
        'RIF' => 'J-111111111'
    ]);
    
    // Crear usuarios de prueba asociados
    $usuarioTest1 = Usuario::create([
        'nombre_usuario' => 'usuario_test1',
        'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
        'correo' => 'test1@empresa.com',
        'tipo_usuario' => 'empresa'
    ]);
    
    $usuarioTest2 = Usuario::create([
        'nombre_usuario' => 'usuario_test2',
        'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
        'correo' => 'test2@empresa.com',
        'tipo_usuario' => 'empresa'
    ]);
    
    UsuarioEmpresa::associate($usuarioTest1, $empresaTestId);
    UsuarioEmpresa::associate($usuarioTest2, $empresaTestId);
    
    echo "Empresa y usuarios creados y asociados\n";
    
    // Eliminar la empresa (debería eliminar los usuarios)
    $deleted = Empresa::delete($empresaTestId);
    echo "Empresa eliminada: " . ($deleted ? "✓" : "✗") . "\n";
    
    // Verificar que los usuarios fueron eliminados
    $usuario1 = Usuario::getById($usuarioTest1);
    $usuario2 = Usuario::getById($usuarioTest2);
    
    echo "Usuario 1 después de eliminar empresa: " . ($usuario1 ? "EXISTE ✗" : "ELIMINADO ✓") . "\n";
    echo "Usuario 2 después de eliminar empresa: " . ($usuario2 ? "EXISTE ✗" : "ELIMINADO ✓") . "\n";
    
} catch (Exception $e) {
    echo "Error en prueba de eliminación: " . $e->getMessage() . "\n";
}

echo "=== PRUEBAS COMPLETADAS ===\n";
?>