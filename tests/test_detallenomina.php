<?php
require_once __DIR__ . '/../models/DetalleNomina.php';
require_once __DIR__ . '/../models/NominaMensual.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../models/UsuarioPostulante.php';

echo "== Prueba completa de los detalles de nomina ==\n";

// Crear tabla
DetalleNomina::createTable();
echo "Tabla creada";

// Crear tablas necesarias
NominaMensual::createTable();
Usuario::createTable();
Empresa::createTable();
UsuarioPostulante::createTable();
echo "🗃️ Tablas Nomina, Usuario, Postulante y Empresa creadas\n";

// Crear usuario de prueba
$usuarioId = Usuario::create([
    'nombre_usuario' => 'test_user',
    'contraseña' => password_hash('test123', PASSWORD_BCRYPT),
    'correo' => 'carlosperez@example.com',
    'tipo_usuario' => 'postulante',
]);
$usuarioId = UsuarioPostulante::add([
    'usuario_id' => $usuarioId,
    'nombre' => 'Carlos',
    'apellido' => 'Pérez',
    'cedula' => '12345678',
    'estado_residencia' => 'Miranda',
    'ciudad_residencia' => 'Los Teques',
    'contratado' => false,
    'tipo_sangre' => 'O+',
    'fecha_nacimiento' => '1990-01-01',
    'genero' => 'masculino'
]);
if (!$usuarioId) {
    die("❌ Error al crear usuario postulante de prueba\n");
} 

$empresaId = Empresa::create([
    'nombre' => 'Empresa de Prueba',
    'razon_social' => 'Empresa de Prueba C.A.',
    'sector' => 'Tecnología',
    'RIF' => 'J-12345678-9',
    'persona_contacto' => 'Juan Pérez'
]);
    
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
    'usuario_id' => 1,
    'nomina_id' => 1,
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