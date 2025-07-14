<?php

require_once __DIR__ . '/../models/NominaMensual.php';
require_once __DIR__ . '/../models/Empresa.php';

echo "=== Prueba completa de NominaMensual con Empresa ===\n";

// 1. Crear tablas
Empresa::createTable();
NominaMensual::createTable();
echo "🗃️ Tablas creadas\n";

// 2. Crear empresa de prueba
$empresaId = Empresa::create([
        'razon_social' => 'Tech Solutions SA',
        'sector' => 'Tecnología',
        'persona_contacto' => 'Juan Pérez',
        'RIF' => 'J-123456789'
    ]);

if (!$empresaId) {
    die("❌ Error al crear empresa de prueba\n");
}
echo "🏢 Empresa creada con ID: $empresaId\n";

// 3. Crear nómina mensual
$nominaData = [
    'empresa_id' => $empresaId,
    'mes' => 'Julio',
    'año' => 2025
];

$nominaId = NominaMensual::create($nominaData);
if ($nominaId) {
    echo "✅ Nómina creada con ID: $nominaId\n";
} else {
    die("❌ Error al crear nómina\n");
}

// 4. Obtener por ID
$nomina = NominaMensual::getById($nominaId);
echo "🔍 Nómina obtenida por ID:\n";
print_r($nomina);

// 5. Obtener por empresa
$nominasEmpresa = NominaMensual::getByCompany($empresaId);
echo "🏢 Nóminas de la empresa:\n";
print_r($nominasEmpresa);

// 6. Actualizar nómina
$actualizado = NominaMensual::update($nominaId, ['mes' => 'Agosto', 'año' => 2025]);
echo $actualizado ? "🔄 Nómina actualizada\n" : "❌ Error al actualizar nómina\n";

// 7. Obtener nómina actualizada
$nominaActualizada = NominaMensual::getById($nominaId);
echo "📋 Nómina actualizada:\n";
print_r($nominaActualizada);

// 8. Eliminar nómina
$eliminado = NominaMensual::delete($nominaId);
echo $eliminado ? "🗑 Nómina eliminada\n" : "❌ Error al eliminar nómina\n";

// 9. Eliminar empresa
$empresaEliminada = Empresa::delete($empresaId);
echo $empresaEliminada ? "✅ Empresa eliminada\n" : "❌ Error al eliminar empresa\n";

echo "=== Prueba completada ===\n";
?>