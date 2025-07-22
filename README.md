# Landscape Project Manager

Sistema integral para la gestión de proyectos de jardinería y paisajismo. Centraliza solicitudes, seguimiento, asignación y administración de proyectos y servicios.

## Características Principales

- ✅ Sistema de solicitudes de servicio público
- ✅ Panel de administración completo
- ✅ Gestión de usuarios con roles (Admin, Supervisor, Técnico, Cliente)
- ✅ Seguimiento de estado de solicitudes
- ✅ Sistema de autenticación seguro
- ✅ Diseño responsive con Bootstrap 5
- 🚧 Gestión de proyectos
- 🚧 Módulo de cotizaciones y facturación
- 🚧 Reportes y estadísticas
- 🚧 Módulo de técnicos/jardineros

## Tecnologías Utilizadas

- **Backend**: PHP 8.x con arquitectura MVC personalizada
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Base de Datos**: MySQL 8
- **Librerías**: Font Awesome, SweetAlert2

## Instalación

### Requisitos Previos

- PHP 8.0 o superior
- MySQL 8.0 o superior
- Servidor web (Apache/Nginx) con mod_rewrite habilitado
- Composer (opcional, para dependencias futuras)

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/danjohn007/Merlos.git
   cd Merlos
   ```

2. **Configurar la base de datos**
   ```bash
   # Crear la base de datos MySQL
   mysql -u root -p < database.sql
   ```

3. **Configurar la aplicación**
   - Editar `app/config/config.php` con sus credenciales de base de datos
   - Ajustar otras configuraciones según sea necesario

4. **Configurar permisos**
   ```bash
   chmod 755 public/uploads/
   chmod 644 .htaccess
   ```

5. **Configurar servidor web**
   - Apuntar el document root a la carpeta del proyecto
   - Asegurar que mod_rewrite esté habilitado

## Configuración

### Base de Datos

Editar `app/config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'landscape_manager');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

### Credenciales por Defecto

**Administrador:**
- Email: admin@landscapemanager.com
- Contraseña: password

## Estructura del Proyecto

```
/
├── app/
│   ├── config/          # Configuración de la aplicación
│   ├── controllers/     # Controladores MVC
│   ├── core/           # Clases principales del framework
│   ├── models/         # Modelos de datos
│   ├── views/          # Vistas de la aplicación
│   └── helpers/        # Funciones auxiliares
├── public/
│   ├── css/            # Archivos CSS
│   ├── js/             # Archivos JavaScript
│   ├── images/         # Imágenes del sitio
│   └── uploads/        # Archivos subidos por usuarios
├── database.sql        # Schema de la base de datos
├── index.php          # Punto de entrada de la aplicación
└── .htaccess          # Configuración de Apache
```

## Módulos Funcionales

### 1. 📝 Módulo de Solicitudes de Servicio
- ✅ Formulario público para clientes
- ✅ Registro automático en base de datos
- ✅ Generación de folio único
- ✅ Subida de archivos adjuntos

### 2. 📋 Módulo de Administración de Solicitudes
- ✅ Panel para revisar solicitudes
- ✅ Filtros por estado
- ✅ Asignación a personal
- ✅ Actualización de estados
- ✅ Notas internas

### 3. 👥 Módulo de Usuarios
- ✅ Sistema de autenticación
- ✅ Roles de usuario (Admin, Supervisor, Técnico, Cliente)
- ✅ Registro de clientes
- ✅ Gestión de permisos

### 4. 🔍 Consulta Pública de Estado
- ✅ Consulta por folio y email
- ✅ Visualización de estado actual
- ✅ Historial de progreso

## Tipos de Usuario

1. **Administrador** - Acceso completo al sistema
2. **Supervisor de Proyectos** - Gestión de proyectos asignados
3. **Jardinero/Técnico** - Acceso a tareas asignadas
4. **Cliente** - Panel personalizado y consultas

## Estados de Solicitudes

- **Nuevo** - Solicitud recién creada
- **En Revisión** - Siendo evaluada
- **Aprobado** - Lista para convertir en proyecto
- **Rechazado** - No procede
- **En Proceso** - Trabajo iniciado
- **Completado** - Servicio finalizado
- **Cancelado** - Cancelado por cualquier motivo

## Desarrollo

Para contribuir al proyecto:

1. Fork el repositorio
2. Crear una rama para su funcionalidad
3. Hacer commit de sus cambios
4. Push a la rama
5. Crear un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT.

## Soporte

Para soporte o consultas, contactar a: info@landscapemanager.com
