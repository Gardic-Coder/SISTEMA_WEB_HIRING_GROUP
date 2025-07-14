<?php

require_once '../models/DetalleNomina.php';
require_once '../models/Nomina.php';
require_once '../models/Usuario.php';

echo "== Prueba completa de los detalles de nomina ==\n";

// Crear tabla
DetalleNomina::createTable();
echo "Tabla creada";

// Crear tablas necesarias
NominaMensual::createTable();
Usuario::createTable();
echo "🗃️ Tablas Nomina y Usuario creadas\n";

// Crear usuario de prueba
$usuarioId = Usuario::create([  
    'nombre' => 'Carlos Gómez',
    'email' => 'carlosperez@example.com',
    'telefono' => '0412-3456789',
    'direccion' => 'Calle Falsa 123',
    'fecha_ingreso' => '2023-01-01',
    'cargo' => 'Desarrollador',
    'salario' => 1000,   
    ]);
if (!$usuarioId) {
    die("❌ Error al crear usuario de prueba\n");
}
echo "Usuario creada con ID: $usuarioId\n";

// Crear nomina de prueba
$nominaId = NominaMensual::create([ 
    'empresa_id' => 1,
    'mes' => 'Enero',
    'año' => 2023
    ]);
if (!$nominaId) {
    die("❌ Error al crear nomina de prueba\n");
}
echo "Nomina creada con ID: $nominaId\n";

// Insertar registro
$data = [
    'nomina_id' => 1,
    'usuario_id' => 1,
    'salario_base' => 1000,
    'descuento_ivss' => 50,
    'descuento_inces' => 20,
    'porcentaje_hiring_group' => 10,
    'salario_neto' => 920
];
$id = DetalleNomina::add($data);
echo "Insertado ID: " . ($id ? $id : 'Error') . "\n";

// Obtener por ID
$detalle = DetalleNomina::getById($id);
echo "Detalle por ID:\n";
print_r($detalle);

// Actualizar registro
$updateData = [
    'salario_base' => 1100,
    'salario_neto' => 1020
];
DetalleNomina::update($id, $updateData);
$detalleActualizado = DetalleNomina::getById($id);
echo "Detalle actualizado:\n";
print_r($detalleActualizado);

// Obtener por nomina
$detallesNomina = DetalleNomina::getByNomina(1);
echo "Detalles por nomina:\n";
print_r($detallesNomina);

// Eliminar por ID
DetalleNomina::deleteById($id);
$detalleEliminado = DetalleNomina::getById($id);
echo "Detalle eliminado (debe ser null):\n";
var_dump($detalleEliminado);

?>