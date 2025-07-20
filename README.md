# 🧠 SISTEMA WEB – Hiring Group

Hiring Group es una empresa nacional dedicada al **reclutamiento, contratación y pagos de personal subcontratado**. Este sistema web fue desarrollado para automatizar y gestionar todos los procesos relacionados con la administración de personal, desde la publicación de vacantes hasta la generación de nómina mensual.

---

## 📌 Objetivo del Proyecto

Desarrollar una plataforma web que permita a Hiring Group y sus empresas clientes:

- Registrar y administrar vacantes laborales.
- Gestionar postulaciones y contrataciones.
- Emitir reportes de nómina y constancias laborales.
- Controlar la data básica del sistema (bancos, usuarios, empresas, etc.).

---

## 👥 Tipos de Usuarios

| Tipo de Usuario         | Funcionalidades principales                                         |
|------------------------ |--------------------------------------------------------------------|
| 🛡️ Administrador        | Acceso total al sistema, gestión de usuarios y empresas.            |
| 🏢 Usuario Hiring Group | Manejo de data básica, nómina, contrataciones.                     |
| 🏭 Usuario Empresa      | Publicación y gestión de ofertas laborales.                         |
| 👤 Postulante/Candidato | Registro, aplicación a ofertas, edición de currículum.              |
| 👷 Usuario Contratado   | Acceso a recibos de pago, constancia laboral.                       |

---

## 🧩 Módulos del Sistema

- **Gestión de empresas**: CRUD de empresas clientes y creación de usuarios RRHH.
- **Ofertas laborales**: Publicación, filtrado y postulación.
- **Contratación**: Registro de condiciones laborales y activación/inactivación de ofertas.
- **Nómina mensual**: Generación de reportes por empresa y globales.
- **Constancia laboral**: Generación automática para usuarios contratados.
- **Manejo de data básica**: Profesiones, bancos, cuentas, teléfonos, etc.

---

## 🛠️ Tecnologías Utilizadas

- **PHP** (sin frameworks)
- **SQLite** como motor de base de datos
- **HTML/CSS/JS** para vistas
- **Git** para control de versiones

---

## 📁 Estructura del Proyecto

```plaintext
📁SISTEMA_WEB_HIRING_GROUP/
├── 📁core/                # Clases base como Database y Auth
│   ├── Database.php
│   └── Auth.php
├── 📁models/              # Modelos de datos
│   ├── Banco.php
│   ├── Categoria.php
│   ├── CategoriaOfertaLaboral.php
│   ├── Contratacion.php
│   ├── CuentaBancaria.php
│   ├── DetalleNomina.php
│   ├── DocumentoUsuario.php
│   ├── Empresa.php
│   ├── ExperienciaLaboral.php
│   ├── FormacionAcademica.php
│   ├── NominaMensual.php
│   ├── OfertaLaboral.php
│   ├── Postulacion.php
│   ├── ProfesionUsuario.php
│   ├── RegistroInicioSesion.php
│   ├── ReporteActividad.php
│   ├── Telefono.php
│   ├── Usuario.php
│   ├── UsuarioEmpresa.php
│   └── UsuarioPostulante.php
├── 📁public/              # Punto de entrada y recursos públicos
│   ├── index.php
│   ├── .htaccess
│   ├── 📁assets/
│       ├── 📁css/
│       ├── 📁docs/
│       ├── 📁font/
│       ├── 📁images/
│       ├── 📁js/
│       └── 📁video/
│   ├── 📁uploads/
│       ├── 📁documents/
│       └── 📁perfiles/
│   └── 📁views/
├── 📁test/                # Pruebas unitarias
│   └── UsuarioTest.php
├── 📁uploads/             # Archivos subidos por usuarios
│   └── 📁perfiles/
├── 📁utils/               # Utilidades y configuración
│   ├── config.php
│   ├── DocumentHandler.php
│   └── ImageHandler.php
└── README.md            # Documentación del proyecto
```

---

## 🧱 Estado del Desarrollo
El proyecto se encuentra en fase activa de construcción. Algunas funcionalidades ya están implementadas, mientras que otras están en desarrollo o planificadas para futuras versiones.
### ✅ Funcionalidades ya implementadas
- Estructura base del proyecto con separación por módulos.
- Modelos principales: Usuario, Empresa, Banco, CuentaBanco, etc.
- Pruebas unitarias para algunos modelos.
- Configuración de base de datos SQLite.
- Manejo de datos básicos (profesiones, teléfonos, formación académica).
### 🚧 Funcionalidades en desarrollo
- Finalización de los modelos restantes.
- Creación de controladores para modelos que lo requieran.
- Implementación de vistas web para cada tipo de usuario.
- Lógica de autenticación y control de acceso por tipo de usuario.
- Registro de acciones del sistema para auditoría (log de eventos).
- Interfaz para generación de constancias laborales.
- Filtros avanzados para ofertas laborales (por salario, área, estado).

---




