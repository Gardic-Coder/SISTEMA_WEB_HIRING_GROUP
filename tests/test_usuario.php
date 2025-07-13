<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Usuario.php';

echo "🔧 Iniciando prueba de Usuario...\n";

// 1. Crear la tabla
echo "🗃️ Creando tabla 'usuario'...\n";
if (Usuario::createTable()) {
    echo "✅ Tabla creada correctamente\n";
} else {
    echo "❌ Error al crear la tabla\n";
}

// 2. Insertar un usuario
$datosUsuario = [
    ':nombre_usuario' => 'maria456',
    ':contraseña' => 'miClaveSegura',
    ':correo' => 'maria@example.com',
    ':tipo_usuario' => 'admin'
];

echo "👤 Insertando usuario...\n";
if (Usuario::insert($datosUsuario)) {
    echo "✅ Usuario insertado correctamente\n";
} else {
    echo "❌ Error al insertar usuario\n";
}

// 3. Buscar por nombre de usuario
echo "🔍 Buscando usuario por nombre...\n";
$resultado = Usuario::findByUsername('maria456');
$usuario = $resultado ? $resultado->fetchArray(SQLITE3_ASSOC) : null;

if ($usuario) {
    echo "✅ Usuario encontrado:\n";
    print_r($usuario);
} else {
    echo "❌ Usuario no encontrado\n";
}

// 4. Validar credenciales correctas
echo "🔐 Validando credenciales correctas...\n";
$validado = Usuario::validateCredentials('maria456', 'miClaveSegura');
if ($validado) {
    echo "✅ Credenciales válidas. Bienvenida, {$validado['nombre_usuario']}!\n";
} else {
    echo "❌ Credenciales inválidas\n";
}

// 5. Validar credenciales incorrectas
echo "🔐 Validando credenciales incorrectas...\n";
$noValido = Usuario::validateCredentials('maria456', 'claveIncorrecta');
if ($noValido) {
    echo "❌ Error: credenciales incorrectas fueron aceptadas\n";
} else {
    echo "✅ Credenciales incorrectas rechazadas\n";
}

echo "✅ Prueba finalizada\n";