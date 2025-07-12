<?php
require_once __DIR__ . '/../core/Database.php';

echo "Prueba de conexión: ";
$db = db();
echo $db ? "OK\n" : "Fallo\n";

// Prueba de creación de tabla
$result = $db->execQuery("CREATE TABLE IF NOT EXISTS test (id INTEGER PRIMARY KEY, nombre TEXT)");
echo "Creación de tabla: " . ($result ? "OK\n" : "Fallo\n");

// Prueba de inserción
$result = $db->preparedQuery("INSERT INTO test (nombre) VALUES (:nombre)", [':nombre' => 'Prueba']);
echo "Inserción: " . ($result ? "OK\n" : "Fallo\n");

// Prueba de consulta
$result = $db->preparedQuery("SELECT * FROM test WHERE nombre = :nombre", [':nombre' => 'Prueba']);
$row = $result->fetchArray(SQLITE3_ASSOC);
echo "Consulta: " . ($row ? "OK - Nombre: {$row['nombre']}\n" : "Fallo\n");
?>