<?php
/**
 * testTelefonoBancoCuenta.php - Pruebas para los modelos de teléfono, banco y cuenta bancaria
 */

require_once __DIR__ . '/../models/Telefono.php';
require_once __DIR__ . '/../models/Banco.php';
require_once __DIR__ . '/../models/CuentaBancaria.php';
require_once __DIR__ . '/../models/Usuario.php';

echo "=== PRUEBAS TELÉFONO, BANCO Y CUENTA BANCARIA ===\n";

// Crear tablas
Telefono::createTable();
Banco::createTable();
CuentaBancaria::createTable();
Usuario::createTable();

// Crear usuario de prueba
$usuarioId = Usuario::create([
    'nombre_usuario' => 'test_cuentas',
    'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
    'correo' => 'test_cuentas@example.com',
    'tipo_usuario' => 'postulante'
]);

// Pruebas de Teléfono
try {
    echo "\n--- Pruebas de Teléfono ---\n";
    
    Telefono::add($usuarioId, '04141234567');
    Telefono::add($usuarioId, '04241234567');
    
    $telefonos = Telefono::getByUsuario($usuarioId);
    echo "Teléfonos del usuario: " . print_r($telefonos, true) . "\n";
    
    // Actualizar un teléfono
    $primerTelefono = $telefonos[0]['ID'];
    Telefono::update($primerTelefono, '04149876543');
    
    // Eliminar un teléfono
    Telefono::delete($telefonos[1]['ID']);
    
    echo "Teléfonos después de actualizar/eliminar: " . print_r(Telefono::getByUsuario($usuarioId), true) . "\n";
} catch (Exception $e) {
    echo "Error en pruebas de Teléfono: " . $e->getMessage() . "\n";
}

// Pruebas de Banco
try {
    echo "\n--- Pruebas de Banco ---\n";
    
    $bancoId1 = Banco::create('Banco de Venezuela');
    $bancoId2 = Banco::create('Banesco');
    
    $bancos = Banco::getAll();
    echo "Bancos registrados: " . print_r($bancos, true) . "\n";
    
    // Actualizar un banco
    Banco::update($bancoId2, 'Banesco Universal');
    
    echo "Bancos después de actualizar: " . print_r(Banco::getAll(), true) . "\n";
} catch (Exception $e) {
    echo "Error en pruebas de Banco: " . $e->getMessage() . "\n";
}

// Pruebas de Cuenta Bancaria
try {
    echo "\n--- Pruebas de Cuenta Bancaria ---\n";
    
    $cuentaId1 = CuentaBancaria::create([
        'usuario_id' => $usuarioId,
        'banco_id' => $bancoId1,
        'nro_cuenta' => '12345678901234567890',
        'tipo_cuenta' => 'ahorro'
    ]);
    
    $cuentaId2 = CuentaBancaria::create([
        'usuario_id' => $usuarioId,
        'banco_id' => $bancoId2,
        'nro_cuenta' => '98765432109876543210',
        'tipo_cuenta' => 'corriente'
    ]);
    
    $cuentas = CuentaBancaria::getByUsuario($usuarioId);
    echo "Cuentas del usuario: " . print_r($cuentas, true) . "\n";
    
    // Desactivar una cuenta
    CuentaBancaria::update($cuentaId1, ['activa' => 0]);
    
    echo "Cuentas después de desactivar una: " . print_r(CuentaBancaria::getByUsuario($usuarioId), true) . "\n";
    
    // Eliminar una cuenta
    CuentaBancaria::delete($cuentaId2);
    
    echo "Cuentas después de eliminar una: " . print_r(CuentaBancaria::getByUsuario($usuarioId), true) . "\n";
} catch (Exception $e) {
    echo "Error en pruebas de Cuenta Bancaria: " . $e->getMessage() . "\n";
}

// Limpieza
Usuario::delete($usuarioId);
Banco::delete($bancoId1);
Banco::delete($bancoId2);

echo "\n=== PRUEBAS COMPLETADAS ===\n";
?>