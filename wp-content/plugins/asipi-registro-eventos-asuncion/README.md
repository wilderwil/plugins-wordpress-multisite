# Asipi - Registro de Usuarios en Asunción 2026

Plugin de WordPress para gestionar el registro de usuarios al evento ASIPI en Asunción 2026.

## Descripción

Sistema completo de registro de participantes para eventos ASIPI que incluye:

- Registro de usuarios (socios, miembros, no socios, invitados)
- Sistema de planes y costos
- Gestión de participantes
- Panel de administración de eventos
- Integración con formularios JotForm
- Sistema de pagos y confirmación

## Versión

**2.0.0** - Adaptado para Asunción 2026

## Características

### Registro de Usuarios

- **Paso 1:** Identificación del usuario y formulario de registro
- **Paso 2:** Confirmación y guardado de registro
- **Paso 3:** Planes y costos del evento
- **Paso 4:** Confirmación final

### Tipos de Usuarios

- Socios ASIPI
- Miembros
- No socios
- Invitados especiales

### Funcionalidades

- `[are_invitadosEspeciales]` - Formulario para invitados especiales
- `[are_planebasasuncion2026]` - Planes y costos del evento
- `[are_edicion]` - Edición de registro
- `[are_confirmacionEdicion]` - Confirmación de edición
- `[arc_config_eventos]` - Panel de configuración y lista de registrados

### Panel de Administración

- **ASIPI Config Evento** - Menú de administración
- Gestión de registros
- Control de tesorería
- Lista de participantes

## Estructura de Archivos

```
asipi-registro-eventos-asuncion/
├── asipi-registro-eventos-asuncion.php  # Archivo principal
├── paso1.php                             # Paso 1 del registro
├── paso2.php                             # Paso 2 - Confirmación
├── paso3.php                             # Paso 3 - Planes
├── paso4.php                             # Paso 4 - Final
├── evento_orden_app.php                  # Gestión de órdenes
├── verificar-login.php                   # Verificación de login
├── css/                                  # Estilos
├── js/                                   # JavaScript
├── include/
│   ├── registro/                         # Sistema de registro
│   │   ├── edicion.php
│   │   ├── invitados.php
│   │   ├── planesasuncion2026.php
│   │   └── registrar.php
│   ├── login/                            # Sistema de login
│   │   ├── socio.php
│   │   ├── miembro.php
│   │   ├── nosocio.php
│   │   └── invitados.php
│   ├── tesoreria/                        # Control financiero
│   └── participantes/                    # Gestión de participantes
└── languages/                            # Traducciones
```

## Instalación

1. Subir la carpeta completa a `/wp-content/plugins/`
2. Activar el plugin desde el panel de WordPress
3. Configurar el evento desde "ASIPI Config Evento" en el menú de admin
4. Crear las páginas necesarias con los shortcodes

## Páginas Requeridas

- `/asuncion2026/registro-evento` - Página principal de registro
- `/asuncion2026/registro-evento-recibo` - Confirmación y recibo
- `/asuncion2026/listado-de-participantes` - Lista de participantes
- `/asuncion2026/registro-edicion` - Edición de registro

## Uso de Shortcodes

```php
// Invitados especiales
[are_invitadosEspeciales]

// Planes del evento
[are_planesasuncion2026]

// Edición de registro
[are_edicion]

// Confirmación de edición
[are_confirmacionEdicion]

// Panel de administración
[arc_config_eventos]
```

## Requisitos

- WordPress 5.0 o superior
- PHP 7.4 o superior
- Acceso a base de datos MySQL
- Permisos de administrador para configuración

## Base de Datos

El plugin utiliza las siguientes tablas personalizadas:

- `evento_orden` - Órdenes de registro
- `evento_meta` - Metadatos del evento
- `pwisa_users` - Usuarios registrados
- `pwisa_usermeta` - Metadatos de usuarios

## Configuración

### Variables de Evento

El plugin lee configuraciones desde la tabla `evento_meta`:

- `url` - URL base del evento
- `blog_id` - ID del sitio en multisite

### Permisos

- Administradores: Acceso completo
- Tesorería: Acceso a registros y pagos
- Secretaría: Acceso a listados y participantes

## Funciones Principales

### Acciones (Actions)

- `the_content` - Inyectar formularios en páginas
- `wp_enqueue_scripts` - Cargar JavaScript
- `admin_menu` - Agregar menús de administración
- `wp_nav_menu_items` - Modificar menú de navegación

### Filtros (Filters)

- `login_url` - Personalizar URL de login

## Desarrollo

Este plugin fue desarrollado para ASIPI y adaptado para el evento de Asunción 2026.

### Origen

Basado en el plugin original de Buenos Aires 2026, adaptado con los siguientes cambios:

- Renombrado de archivos y carpetas
- Actualización de URLs (/asuncion2026/)
- Cambio de referencias de "Buenos Aires" a "Asunción"
- Ajuste de funciones (planesasuncion2026)

### Changelog

**v2.0.0 - 2026-01-28**
- Adaptación completa para Asunción 2026
- Renombrado de plugin y archivos
- Actualización de URLs y referencias
- Documentación completa

## Autor

**ZT Group Corp Team**

## Soporte

Para soporte o consultas sobre el plugin, contactar al equipo de desarrollo.

## Licencia

Este plugin es de uso interno para ASIPI.

---

## Notas Técnicas

### Integración con WordPress Multisitio

El plugin está diseñado para trabajar con WordPress Multisitio:

```php
global $blog_id;
$event_id = $blog_id;
```

### Ajax

El plugin utiliza admin-ajax.php para operaciones asíncronas:

```javascript
ajaxurl: admin_url('admin-ajax.php')
```

### Seguridad

- Validación de usuarios logueados
- Verificación de capacidades (manage_options)
- Sanitización de inputs
- Prepared statements para consultas SQL

## Próximas Mejoras

- [ ] Sistema de notificaciones por email
- [ ] Exportación de datos en Excel
- [ ] Integración con pasarelas de pago
- [ ] Reportes estadísticos
- [ ] API REST para integración externa
