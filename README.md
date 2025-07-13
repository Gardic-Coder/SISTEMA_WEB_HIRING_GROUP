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

| Tipo de Usuario         | Funcionalidades principales |
|-------------------------|-----------------------------|
| 🛡️ Administrador         | Acceso total al sistema, gestión de usuarios y empresas. |
| 🏢 Usuario Hiring Group  | Manejo de data básica, nómina, contrataciones. |
| 🏭 Usuario Empresa       | Publicación y gestión de ofertas laborales. |
| 👤 Postulante/Candidato  | Registro, aplicación a ofertas, edición de currículum. |
| 👷 Usuario Contratado    | Acceso a recibos de pago, constancia laboral. |

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

📁 SISTEMA_WEB_HIRING_GROUP/ 
├── 📁 core/               # Clases base como Database y Auth │   
    ├── Database.php │   
    └── Auth.php 
├── 📁 models/             # Modelos de datos │   
    ├── Banco.php │   
    ├── CuentaBanco.php │   
    ├── Empresa.php │   
    ├── ExperienciaLaboral.php │   
    ├── FormacionAcademica.php │   
    ├── ProfesionUsuario.php │   
    ├── Telefono.php │   
    ├── Usuario.php │   
    └── UsuarioEmpresa.php 
├── 📁 public/             # Punto de entrada y recursos públicos │   
    ├── index.php │   
    └── 📁 assets/ │       
        ├── css/ │       
        ├── js/ │       
        └── docs/ 
├── 📁 test/               # Pruebas unitarias │   
    └── UsuarioTest.php 
├── 📁 uploads/            # Archivos subidos por usuarios │   
    └── perfiles/ 
├── 📁 utils/              # Utilidades y configuración │   
    ├── config.php │   
    └── ImageHandler.php 
└── 📄 README.md           # Documentación del proyecto