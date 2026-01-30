# Análisis Completo: Plugin ASIPI Registro Eventos Asunción 2026

**Fecha de análisis:** 2026-01-28
**Versión del plugin:** 2.0.0
**Autor:** ZT Group Corp Team

---

## 📊 Resumen Ejecutivo

Plugin de WordPress diseñado para gestionar el registro de participantes al evento ASIPI en Asunción 2026. Sistema completo con módulos de registro, pagos, tesorería y gestión de participantes.

### Métricas Generales

| Métrica | Valor |
|---------|-------|
| **Archivos PHP** | 52 |
| **Archivos JavaScript** | 3 |
| **Archivos CSS** | 1 |
| **Tamaño total** | 1.1 MB |
| **Líneas de código** | ~19,603 |
| **Funciones principales** | 18 |
| **Shortcodes** | 11 |
| **Hooks (actions/filters)** | 7 |

---

## 🏗️ Arquitectura del Plugin

### Estructura de Directorios

```
asipi-registro-eventos-asuncion/
├── asipi-registro-eventos-asuncion.php  (258 líneas) - Archivo principal
├── README.md                             (224 líneas) - Documentación
├── paso1.php                             (476 líneas) - Paso 1 del registro
├── paso2.php                             (75 líneas)  - Confirmación
├── paso3.php                             (79 líneas)  - Planes y costos
├── paso4.php                             (91 líneas)  - Finalización
├── evento_orden_app.php                  (33 líneas)  - API de órdenes
├── verificar-login.php                   (23 líneas)  - Verificación de acceso
│
├── css/
│   └── style_registro.css                - Estilos del sistema de registro
│
├── js/
│   ├── script.js                         (596 líneas) - JavaScript principal
│   ├── script_teso.js                    (38 líneas)  - JS de tesorería
│   └── menu.js                           (13 líneas)  - Manejo de menús
│
├── include/
│   ├── certificado/                      - Sistema de certificados PDF
│   │   ├── CertificadoAsipiAcademia.jpg
│   │   ├── CertificadoAsipiAcademia.pdf
│   │   └── certificado.php               (137 líneas)
│   │
│   ├── invoice/                          - Sistema de facturación
│   │   ├── dlInvoice.php                 (659 líneas) - Descarga de facturas
│   │   ├── dlInvoiceEvento.php           (461 líneas) - Facturas de eventos
│   │   ├── invoice-design.php            (162 líneas) - Diseño de facturas
│   │   └── invoice.php                   (161 líneas) - Generación de facturas
│   │
│   ├── login/                            - Sistema de autenticación
│   │   ├── getUserLogueado.php           (238 líneas) - Obtener usuario actual
│   │   ├── invitados.php                 (337 líneas) - Login de invitados
│   │   ├── login.php                     (166 líneas) - Login general
│   │   ├── miembro.php                   (115 líneas) - Login de miembros
│   │   ├── newUser.php                   (76 líneas)  - Crear nuevo usuario
│   │   ├── nosocio.php                   (235 líneas) - Login de no socios
│   │   ├── rutas.php                     (223 líneas) - Gestión de rutas
│   │   └── socio.php                     (1 línea)    - Login de socios
│   │
│   ├── participantes/                    - Gestión de participantes
│   │   └── listado.php                   (535 líneas) - Lista de participantes
│   │
│   ├── registro/                         - Sistema de registro
│   │   ├── edicion.php                   (367 líneas) - Editar registro
│   │   ├── hotel.php                     (225 líneas) - Reserva de hotel
│   │   ├── invitados.php                 (314 líneas) - Registro de invitados
│   │   ├── jotform.php                   (337 líneas) - Integración JotForm
│   │   ├── jotform-edicion.php           (233 líneas)
│   │   ├── jotform-hotel.php             (219 líneas)
│   │   ├── jotform-running.php           (201 líneas)
│   │   ├── jotform-rutas.php             (217 líneas)
│   │   ├── paso1-btn.php                 (113 líneas)
│   │   ├── paso1-invitados.php           (179 líneas)
│   │   ├── paso1-mixto.php               (586 líneas)
│   │   ├── paso1-presencial.php          (1481 líneas) - Mayor archivo del plugin
│   │   ├── paso1-virtual.php             (596 líneas)
│   │   ├── planes.php                    (614 líneas) - Planes generales
│   │   ├── planes_inc.php                (388 líneas) - Planes incluidos
│   │   ├── planesasuncion2026.php        (602 líneas) - Planes Asunción 2026
│   │   ├── planespanama2024-original.php (351 líneas) - Referencia Panamá
│   │   ├── registrar.php                 (1281 líneas) - Procesamiento de registro
│   │   ├── registrarEdicion.php          (602 líneas)
│   │   ├── registrarEdicion_.php         (684 líneas)
│   │   ├── registrarHotel.php            (635 líneas)
│   │   ├── registrarRutas.php            (1081 líneas)
│   │   ├── running.php                   (228 líneas)
│   │   └── rutas.php                     (309 líneas)
│   │
│   ├── tesoreria/                        - Control financiero
│   │   ├── config_lista.php              (241 líneas) - Configuración listas
│   │   ├── core.php                      (39 líneas)  - Core de tesorería
│   │   ├── enviar_certificado.php        (252 líneas) - Envío de certificados
│   │   ├── lista_registros.php           (759 líneas) - Lista de registrados
│   │   ├── nuevo_registro.php            (327 líneas) - Nuevo registro manual
│   │   └── verificarEmail.php            (95 líneas)  - Verificación de email
│   │
│   ├── paso1.php                         (324 líneas) - Paso 1 (include)
│   └── paso1.phpy                        (310 líneas) - Backup de paso1
│
└── languages/                            - Traducciones (vacío)
```

---

## 🔌 Componentes Principales

### 1. Archivo Principal (asipi-registro-eventos-asuncion.php)

**Funciones Registradas:** 18 funciones principales

#### Actions (add_action)

1. **`the_content`** → `are_paso1_registro_eventos()`
   - Inyecta el formulario de registro en la página
   - Activa en: `is_page('registro-evento')`
   - Carga estilos y template de paso 1

2. **`the_content`** → `are_paso2_registro_eventos()`
   - Procesa y muestra confirmación de registro
   - Activa en: `is_page('registro-evento-recibo')`
   - Incluye: `include/registro/registrar.php`

3. **`wp_enqueue_scripts`** → `are_insertar_js()`
   - Carga JavaScript del plugin
   - Pasa `admin-ajax.php` URL para Ajax

4. **`admin_menu`** → `asipi_registro_evento_init()`
   - Crea menú "ASIPI Config Evento" en admin
   - Permisos: `manage_options`
   - Icono: `dashicons-wordpress`

#### Filters (add_filter)

1. **`login_url`** → `my_login_url()`
   - Personaliza URL de login (actualmente vacía)

2. **`wp_nav_menu_items`** → `add_extra_item_to_nav_menu()`
   - Modifica menú de navegación dinámicamente
   - Agrega enlaces según estado del usuario
   - Enlaces condicionales: Participantes, Edición

---

### 2. Shortcodes Disponibles

| Shortcode | Función | Descripción | Estado |
|-----------|---------|-------------|--------|
| `[are_hotel]` | `are_registroHotel()` | Reserva de hotel | Comentado |
| `[are_running]` | `are_registroRunning()` | Registro running | Comentado |
| `[are_rutas]` | `are_registroRutas()` | Registro de rutas | Comentado |
| `[are_confirmacionRutas]` | `are_confirmacionRutas()` | Confirmación rutas | Comentado |
| `[are_invitadosEspeciales]` | `are_invitadosEspeciales()` | Invitados especiales | ✅ Activo |
| `[are_confirmacionHotel]` | `are_confirmacionHotel()` | Confirmación hotel | Comentado |
| `[are_edicion]` | `are_registroEdicion()` | Editar registro | ✅ Activo |
| `[are_confirmacionEdicion]` | `are_confirmacionEdicion()` | Confirmación edición | ✅ Activo |
| `[are_planes]` | `are_planescostos()` | Planes generales | Comentado |
| `[are_planesasuncion2026]` | `are_planescostosasuncion2026()` | Planes Asunción 2026 | ✅ Activo |
| `[arc_config_eventos]` | `arc_lista_registrados()` | Panel administración | ✅ Activo |

**Shortcodes activos:** 5 de 11

---

### 3. Sistema de Registro (Flujo de 4 Pasos)

#### Paso 1: Identificación y Formulario
- **Archivo:** `include/paso1.php` (324 líneas)
- **Trigger:** Página `registro-evento`
- **Función:** Identificar usuario y mostrar formulario JotForm
- **Variantes:**
  - `paso1-presencial.php` (1481 líneas) - Más complejo
  - `paso1-virtual.php` (596 líneas)
  - `paso1-mixto.php` (586 líneas)
  - `paso1-invitados.php` (179 líneas)

#### Paso 2: Guardar y Confirmar
- **Archivo:** `paso2.php` (75 líneas)
- **Función:** Procesar datos y mostrar confirmación
- **Incluye:** `include/registro/registrar.php` (1281 líneas)
- **Validación:** Verifica `$_REQUEST['email']`

#### Paso 3: Planes y Costos
- **Archivo:** `paso3.php` (79 líneas)
- **Función:** Mostrar planes disponibles
- **Shortcode:** `[are_planesasuncion2026]`

#### Paso 4: Finalización
- **Archivo:** `paso4.php` (91 líneas)
- **Función:** Confirmación final y recibo

---

### 4. Sistema de Autenticación (Login)

Módulo ubicado en: `include/login/`

#### Tipos de Usuario

1. **Socios** (`socio.php`)
   - Archivo casi vacío (1 línea)
   - Posiblemente deshabilitado

2. **Miembros** (`miembro.php` - 115 líneas)
   - Validación de membresía
   - Acceso a funciones de miembro

3. **No Socios** (`nosocio.php` - 235 líneas)
   - Registro para público general
   - Proceso de pago diferente

4. **Invitados** (`invitados.php` - 337 líneas)
   - Sistema especial para invitados VIP
   - Bypass de algunos pasos

#### Funciones de Login

- **`getUserLogueado.php`** (238 líneas)
  - Obtiene datos del usuario actual
  - Verifica permisos y estado
  - Retorna información completa del usuario

- **`login.php`** (166 líneas)
  - Proceso de login general
  - Redirecciones post-login

- **`newUser.php`** (76 líneas)
  - Crear nuevos usuarios desde registro
  - Sincronización con WordPress users

---

### 5. Sistema de Facturación (Invoice)

Módulo ubicado en: `include/invoice/`

#### Componentes

1. **`dlInvoice.php`** (659 líneas)
   - Descarga de facturas en PDF
   - Sistema de cursos y registros

2. **`dlInvoiceEvento.php`** (461 líneas)
   - Facturas específicas de eventos
   - Integración con sistema de pagos

3. **`invoice-design.php`** (162 líneas)
   - Diseño HTML/CSS de facturas
   - Template personalizable

4. **`invoice.php`** (161 líneas)
   - Generación de facturas
   - Cálculos y totales

**Características:**
- Generación de PDF
- Números de factura automáticos
- Múltiples idiomas (ES/EN)
- Logo y branding ASIPI

---

### 6. Sistema de Tesorería

Módulo ubicado en: `include/tesoreria/`

#### Funcionalidades

1. **Panel de Control** (`core.php` - 39 líneas)
   - Núcleo del sistema de tesorería
   - Integración con shortcode `[arc_config_eventos]`

2. **Lista de Registros** (`lista_registros.php` - 759 líneas)
   - Tabla completa de registrados
   - Filtros y búsquedas
   - Exportación de datos
   - Estados: Confirmado (C), Pendiente (P), etc.

3. **Configuración** (`config_lista.php` - 241 líneas)
   - Configuración de visualización
   - Columnas personalizables
   - Permisos de acceso

4. **Nuevo Registro Manual** (`nuevo_registro.php` - 327 líneas)
   - Crear registros desde admin
   - Para secretaría/tesorería
   - Bypass de proceso normal

5. **Envío de Certificados** (`enviar_certificado.php` - 252 líneas)
   - Envío masivo o individual
   - Generación automática
   - Tracking de envíos

6. **Verificación de Email** (`verificarEmail.php` - 95 líneas)
   - Validar emails de usuarios
   - Evitar duplicados
   - Verificación de existencia

#### Permisos de Acceso

```php
// Administradores
current_user_can('manage_options')

// Tesorería/Secretaría
meta_key = "pwisa_capabilities"
meta_value LIKE "%tesoreria%" OR meta_value LIKE "%secretaria%"
```

---

### 7. Gestión de Participantes

Módulo ubicado en: `include/participantes/`

#### `listado.php` (535 líneas)

**Funcionalidades:**
- Lista completa de participantes registrados
- Acceso restringido:
  - Usuarios con registro confirmado
  - Administradores
  - Tesorería/Secretaría
- Formulario de contacto entre participantes
- Exportación de lista

**URL:** `/asuncion2026/listado-de-participantes`

**Condiciones de acceso:**
```php
// Usuario con registro visible
SELECT pwisa_users_ID FROM evento_orden
WHERE pwisa_users_ID = $user_id
AND visible = 1
AND evento_id = $event_id

// O es admin/secretaría
```

---

### 8. Sistema de Certificados

Módulo ubicado en: `include/certificado/`

#### `certificado.php` (137 líneas)

**Características:**
- Generación de certificados en PDF
- Template: `CertificadoAsipiAcademia.pdf`
- Imagen: `CertificadoAsipiAcademia.jpg`
- Personalización con datos del participante
- Descarga automática

**Acceso:**
- URL: `registro-evento-recibo?certificado=1`
- Requiere usuario logueado y registrado

---

## 🗄️ Base de Datos

### Tablas Utilizadas

#### 1. `evento_orden`
**Propósito:** Órdenes de registro de participantes

**Campos principales:**
- `pwisa_users_ID` - ID del usuario WordPress
- `evento_id` - ID del evento (blog_id en multisite)
- `numero` - Número de orden
- `subnumero` - Sub-número (para acompañantes)
- `estado` - Estado: C (Confirmado), P (Pendiente), E, R
- `visible` - Si la orden es visible (1/0)
- `tipo` - Tipo de participante (1, 2, etc.)

**Consultas comunes:**
```sql
-- Verificar si usuario tiene registro
SELECT pwisa_users_ID FROM evento_orden
WHERE pwisa_users_ID = $user_id
AND visible = 1
AND evento_id = $event_id

-- Registro principal del usuario
SELECT pwisa_users_ID FROM evento_orden
WHERE pwisa_users_ID = $user_id
AND subnumero = 1
AND visible = 1
AND estado IN ('C','P')
AND evento_id = $event_id
```

#### 2. `evento_meta`
**Propósito:** Metadatos del evento

**Estructura:**
- `clave` - Clave del metadato
- `valor` - Valor del metadato
- `evento_id` - ID del evento

**Metadatos comunes:**
- `url` - URL base del evento (/asuncion2026/)
- `name_es` - Nombre en español
- `name_en` - Nombre en inglés

#### 3. `evento_orden_concepto`
**Propósito:** Conceptos/items de cada orden

**Relación:** Uno a muchos con `evento_orden`

#### 4. `pwisa_users` / `pwisa_usermeta`
**Propósito:** Usuarios de WordPress (con prefijo personalizado)

**Nota:** Usa prefijo `pwisa_` en lugar de `wp_`

#### 5. `pwisa_teso_orden`
**Propósito:** Órdenes de tesorería

**Estados:**
- `P` - Pagado
- Otros estados según proceso

---

## 🔒 Análisis de Seguridad

### ⚠️ Puntos Críticos Detectados

#### 1. Alto Uso de Variables Sin Sanitizar

**Estadísticas:**
- `$_REQUEST`, `$_GET`, `$_POST` usados: **561 veces**
- Uso de `sanitize_*`: **0 veces**
- Uso de `esc_*`: **12 veces**

**Riesgo:** Alto
**Impacto:** Potencial inyección de código, XSS

**Ejemplo encontrado:**
```php
// asipi-registro-eventos-asuncion.php:44
if (isset($_REQUEST['email'])) {
    include('include/registro/registrar.php');
    // $_REQUEST['email'] usado directamente sin sanitizar
}
```

#### 2. Consultas SQL con Concatenación

**Ejemplos encontrados:**

```php
// Línea 53
$event_url = $wpdb->get_var("SELECT valor FROM evento_meta WHERE clave = 'url' and evento_id = $blog_id");

// Línea 182
$sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and visible = 1 and evento_id = '$event_id'";

// evento_orden_app.php:13
$numero_orden= $wpdb->get_var("SELECT numero FROM evento_orden WHERE pwisa_users_ID= $user_id AND subnumero=1 AND visible=1 and evento_id=35 and tipo in (1,2)");
```

**Riesgo:** Medio a Alto
**Impacto:** Potencial SQL Injection

**Nota:** Aunque se usa `$wpdb` (que es bueno), las consultas usan concatenación directa en lugar de prepared statements.

#### 3. Archivos Sensibles sin Protección

**Archivos detectados:**
- `include/paso1.phpy` - Archivo backup con extensión incorrecta
- Múltiples archivos `jotform-*.php` - Posible exposición de keys

#### 4. Permisos y Capacidades

**Positivo:** ✅
- Verifica `manage_options` para admin
- Valida capacidades de tesorería/secretaría
- Usa `is_user_logged_in()`

**Mejorable:**
- Algunos archivos no verifican permisos antes de ejecutar
- Falta verificación de nonces en formularios

---

### ✅ Puntos Positivos de Seguridad

1. **Uso de WordPress APIs**
   - Usa `$wpdb` para base de datos
   - `wp_get_current_user()` para usuario actual
   - `current_user_can()` para permisos

2. **Verificación de Login**
   - `is_user_logged_in()` usado consistentemente
   - Redirecciones apropiadas

3. **Prevención de Acceso Directo**
   ```php
   if (!defined('ABSPATH')) {
       exit;
   }
   ```
   **Nota:** NO encontrado en el archivo principal, pero recomendable agregarlo.

---

### 🛡️ Recomendaciones de Seguridad

#### Prioridad Alta

1. **Sanitizar TODOS los inputs**
   ```php
   // Mal
   $email = $_REQUEST['email'];

   // Bien
   $email = sanitize_email($_REQUEST['email']);
   $user_id = absint($_REQUEST['user_id']);
   $text = sanitize_text_field($_POST['text']);
   ```

2. **Usar Prepared Statements**
   ```php
   // Mal
   $sql = "SELECT * FROM evento_orden WHERE pwisa_users_ID = '$user_id'";

   // Bien
   $sql = $wpdb->prepare(
       "SELECT * FROM evento_orden WHERE pwisa_users_ID = %d",
       $user_id
   );
   ```

3. **Agregar Nonces a Formularios**
   ```php
   wp_nonce_field('are_registro_action', 'are_registro_nonce');

   // Al procesar
   if (!wp_verify_nonce($_POST['are_registro_nonce'], 'are_registro_action')) {
       wp_die('Acción no autorizada');
   }
   ```

#### Prioridad Media

4. **Escapar Outputs**
   ```php
   echo esc_html($user_name);
   echo esc_url($redirect_url);
   echo esc_attr($input_value);
   ```

5. **Validar Permisos en Todos los Endpoints**
   ```php
   if (!current_user_can('manage_options')) {
       wp_die('No tienes permisos');
   }
   ```

6. **Eliminar Archivos Backup**
   - Eliminar `include/paso1.phpy`
   - Usar `.bak` o `.backup` y agregarlos a `.gitignore`

---

## ⚙️ Dependencias y Integraciones

### Dependencias de WordPress

**Core WordPress:**
- `$wpdb` - Acceso a base de datos
- `wp_get_current_user()` - Usuario actual
- `current_user_can()` - Verificación de permisos
- `wp_enqueue_style()` / `wp_enqueue_script()` - Carga de assets
- `add_action()` / `add_filter()` - Hooks de WordPress
- `wp_localize_script()` - Pasar datos a JavaScript
- `plugin_dir_path()` / `plugin_dir_url()` - Rutas del plugin

**WordPress Multisite:**
- `global $blog_id` - ID del sitio en red multisite
- Diseñado específicamente para multisitio

### Integraciones Externas

#### 1. JotForm
**Archivos:**
- `include/registro/jotform.php`
- `include/registro/jotform-edicion.php`
- `include/registro/jotform-hotel.php`
- `include/registro/jotform-running.php`
- `include/registro/jotform-rutas.php`

**Propósito:** Formularios de registro externos embebidos

#### 2. Sistema de Pagos (Implícito)
- Mencionado en código pero no implementado visiblemente
- Referencia a `pwisa_teso_orden` (órdenes de tesorería)

#### 3. jQuery (JavaScript)
```php
wp_register_script('are_miscript', $my_plugin, array('jquery'), rand(0, 99), true);
```

---

## 🌐 URLs y Páginas Requeridas

### Páginas de WordPress Necesarias

| Slug | URL | Propósito |
|------|-----|-----------|
| `registro-evento` | `/asuncion2026/registro-evento` | Página principal de registro |
| `registro-evento-recibo` | `/asuncion2026/registro-evento-recibo` | Confirmación y recibo |
| `listado-de-participantes` | `/asuncion2026/listado-de-participantes` | Lista de participantes |
| `registro-edicion` | `/asuncion2026/registro-edicion` | Editar registro existente |

### Endpoints Especiales

**Certificados:**
```
/asuncion2026/registro-evento-recibo?certificado=1
```

**Facturas:**
```
/asuncion2026/registro-evento-recibo?numero=123&tipo=1
```

---

## 📱 JavaScript y AJAX

### Archivos JavaScript

#### 1. `js/script.js` (596 líneas)
**Funcionalidades:**
- Manejo de formularios
- Validaciones client-side
- Llamadas AJAX a `admin-ajax.php`
- Interactividad del registro

#### 2. `js/script_teso.js` (38 líneas)
**Funcionalidades:**
- Específico para tesorería
- Manejo de panel de administración

#### 3. `js/menu.js` (13 líneas)
**Funcionalidades:**
- Comportamiento de menús
- Navegación dinámica

### AJAX Setup

```php
// En el archivo principal
wp_localize_script('are_miscript','dcms_vars',[
    'ajaxurl' => admin_url('admin-ajax.php')
]);
```

**Permite:** Hacer peticiones Ajax desde JavaScript al backend de WordPress

---

## 🎨 CSS y Estilos

### `css/style_registro.css`

**Carga condicional:**
```php
wp_enqueue_style('are_styles',
    '/wp-content/plugins/asipi-registro-eventos-asuncion/css/style_registro.css',
    false,
    '1.8', // Versión
    'all'
);
```

**Versiones encontradas:**
- v1.4 - Paso 2
- v1.8 - Paso 1, shortcodes

**Propósito:**
- Estilos del formulario de registro
- Diseño de pasos
- Elementos visuales del proceso

---

## 🔄 Flujo de Usuario Completo

### Escenario: Socio ASIPI registrándose

```
1. INICIO
   ├─ Usuario accede a /asuncion2026/registro-evento
   ├─ Plugin detecta: is_page('registro-evento')
   └─ Ejecuta: are_paso1_registro_eventos()

2. PASO 1: Identificación
   ├─ Verifica si está logueado
   │  ├─ SI → Obtiene datos del usuario
   │  └─ NO → Muestra opciones de login
   ├─ Determina tipo de usuario (socio/miembro/no-socio)
   ├─ Carga formulario apropiado (paso1-presencial.php)
   └─ Muestra formulario JotForm embedded

3. USUARIO COMPLETA FORMULARIO
   ├─ Submit del formulario
   ├─ POST a /asuncion2026/registro-evento-recibo
   └─ Datos en $_REQUEST

4. PASO 2: Procesamiento
   ├─ Plugin detecta: is_page('registro-evento-recibo')
   ├─ Verifica: isset($_REQUEST['email'])
   ├─ Ejecuta: include('include/registro/registrar.php')
   │  ├─ Valida datos (sin sanitizar - RIESGO)
   │  ├─ Inserta en evento_orden
   │  ├─ Genera número de orden
   │  └─ Crea registro en BD
   └─ Muestra: paso2.php (confirmación)

5. PASO 3: Planes y Costos (Opcional)
   ├─ Shortcode: [are_planesasuncion2026]
   ├─ Muestra planes disponibles
   ├─ Usuario selecciona plan
   └─ Actualiza orden con concepto

6. PASO 4: Finalización
   ├─ Muestra recibo completo
   ├─ Opción de descargar factura
   ├─ Opción de descargar certificado
   └─ Mensaje de confirmación

7. POST-REGISTRO
   ├─ Usuario puede editar: /asuncion2026/registro-edicion
   ├─ Usuario puede ver participantes
   ├─ Admin puede gestionar desde panel
   └─ Tesorería puede validar pagos
```

---

## 🏷️ Tipos de Participantes

### 1. Socio ASIPI
- **Identificación:** Miembro activo de ASIPI
- **Validación:** Tabla `pwisa_users` + metadatos
- **Beneficios:** Descuentos, acceso prioritario
- **Login:** `include/login/socio.php`

### 2. Miembro
- **Identificación:** Miembro sin ser socio pleno
- **Login:** `include/login/miembro.php`
- **Proceso:** Similar a socio con diferencias de precio

### 3. No Socio
- **Identificación:** Público general
- **Login:** `include/login/nosocio.php`
- **Proceso:** Registro completo requerido

### 4. Invitado Especial
- **Identificación:** Invitados VIP
- **Login:** `include/login/invitados.php`
- **Shortcode:** `[are_invitadosEspeciales]`
- **Proceso:** Simplificado, posible sin pago

---

## 📊 Estados del Registro

### Estados en `evento_orden.estado`

| Código | Significado | Acción |
|--------|-------------|--------|
| **C** | Confirmado | Registro completado y validado |
| **P** | Pendiente | Esperando confirmación/pago |
| **E** | ??? | Estado no documentado |
| **R** | ??? | Estado no documentado |

### Visibilidad: `evento_orden.visible`

| Valor | Significado |
|-------|-------------|
| **1** | Visible (registro activo) |
| **0** | Oculto (cancelado o inactivo) |

---

## 🔧 Configuración del Plugin

### Metadatos del Evento (`evento_meta`)

```sql
-- URL base del evento
INSERT INTO evento_meta (clave, valor, evento_id)
VALUES ('url', '/asuncion2026/', 35);

-- Nombre del evento (español)
INSERT INTO evento_meta (clave, valor, evento_id)
VALUES ('name_es', 'Congreso ASIPI Asunción 2026', 35);

-- Nombre del evento (inglés)
INSERT INTO evento_meta (clave, valor, evento_id)
VALUES ('name_en', 'ASIPI Congress Asunción 2026', 35);
```

### Configuración Hardcoded

**En `evento_orden_app.php`:**
```php
// Evento hardcoded a ID 35
evento_id = 35
```

**Recomendación:** Hacer esto configurable desde admin o usar `$blog_id` dinámicamente.

---

## 🌍 Internacionalización (i18n)

### Soporte Multiidioma

**Evidencia encontrada:**
```php
// En add_extra_item_to_nav_menu()
__("<!--:es-->Registro<!--:--><!--:en-->Register<!--:-->")
__("<!--:es-->Participantes<!--:--><!--:en-->List of Participants<!--:-->")
__("<!--:es-->Edición<!--:--><!--:en-->Edit<!--:-->")
```

**Método:** qTranslate-X style separators

**Carpeta:** `languages/` (vacía actualmente)

**Idiomas soportados:**
- Español (es)
- Inglés (en)

### Recomendación

Migrar a sistema estándar de WordPress:
```php
// Usar
__('Registro', 'asipi-registro-eventos-asuncion');
_e('Participantes', 'asipi-registro-eventos-asuncion');

// Y crear archivos .po/.mo en languages/
```

---

## 📈 Métricas de Código

### Archivos Más Grandes

| Archivo | Líneas | Propósito |
|---------|--------|-----------|
| `include/registro/paso1-presencial.php` | 1481 | Formulario presencial completo |
| `include/registro/registrar.php` | 1281 | Procesamiento principal de registro |
| `include/registro/registrarRutas.php` | 1081 | Registro de rutas |
| `include/tesoreria/lista_registros.php` | 759 | Lista admin de registros |
| `include/registro/registrarEdicion_.php` | 684 | Edición de registro (versión 2) |

### Complejidad por Módulo

| Módulo | Archivos | Líneas Aprox. | Complejidad |
|--------|----------|---------------|-------------|
| **Registro** | 21 | ~10,000 | Alta |
| **Login** | 7 | ~1,500 | Media |
| **Tesorería** | 6 | ~1,900 | Alta |
| **Invoice** | 4 | ~1,500 | Media |
| **Participantes** | 1 | ~500 | Baja |
| **Certificado** | 1 | ~140 | Baja |

---

## ⚠️ Problemas y Code Smells Detectados

### 1. Código Comentado Excesivo

**Problema:** Múltiples secciones grandes comentadas en lugar de eliminadas

**Ejemplo:**
```php
/*
add_shortcode('are_hotel', 'are_registroHotel');
function are_registroHotel() {
    require_once plugin_dir_path(__FILE__) . 'include/registro/hotel.php';
}
*/
```

**Recomendación:** Eliminar código no usado o mover a archivos `.backup`

### 2. Archivo Backup en Producción

**Problema:** `include/paso1.phpy` - Extensión incorrecta

**Riesgo:** Puede ser accesible directamente vía web

**Solución:** Eliminar o renombrar a `.bak` y agregar a `.gitignore`

### 3. IDs Hardcoded

**Problema:**
```php
evento_id = 35  // Hardcoded en evento_orden_app.php
```

**Recomendación:** Usar `$blog_id` global o hacer configurable

### 4. Inconsistencia en Nombrado

**Problema:**
- `are_` prefix (Asipi Registro Eventos)
- `arc_` prefix (Asipi Registro Cursos)

**Sugerencia:** Unificar prefijos

### 5. Falta de Documentación en Código

**Problema:** Casi sin comentarios PHPDoc

**Ejemplo de cómo debería ser:**
```php
/**
 * Procesa el paso 1 del registro de eventos
 *
 * @param string $content Contenido de la página
 * @return string Contenido modificado con formulario
 */
function are_paso1_registro_eventos( $content ) {
    // ...
}
```

---

## ✅ Puntos Fuertes del Plugin

### 1. Arquitectura Modular

✅ Excelente separación de responsabilidades:
- Login separado de registro
- Facturación independiente
- Tesorería como módulo aparte

### 2. Multisite Ready

✅ Diseñado específicamente para WordPress Multisite:
```php
global $blog_id;
$event_id = $blog_id;
```

### 3. Flexible y Extensible

✅ Sistema de shortcodes permite múltiples configuraciones:
- Eventos presenciales
- Eventos virtuales
- Eventos mixtos
- Invitados especiales

### 4. Sistema de Permisos Robusto

✅ Múltiples niveles de acceso:
- Administradores
- Tesorería
- Secretaría
- Participantes registrados
- Usuarios logueados

### 5. Integración con JotForm

✅ Permite formularios complejos sin programación adicional

---

## 🚀 Recomendaciones de Mejora

### Prioridad Crítica

1. **Implementar sanitización completa**
   - Afecta seguridad del sitio
   - Esfuerzo: Alto
   - Tiempo estimado: 2-3 días

2. **Migrar a prepared statements**
   - Prevenir SQL injection
   - Esfuerzo: Medio
   - Tiempo estimado: 1-2 días

3. **Agregar protección CSRF (nonces)**
   - En todos los formularios
   - Esfuerzo: Medio
   - Tiempo estimado: 1 día

### Prioridad Alta

4. **Documentar código (PHPDoc)**
   - Mejorar mantenibilidad
   - Esfuerzo: Alto
   - Tiempo estimado: 3-4 días

5. **Eliminar código comentado**
   - Limpiar archivo principal
   - Esfuerzo: Bajo
   - Tiempo estimado: 2-3 horas

6. **Crear tests unitarios**
   - Al menos para funciones críticas
   - Esfuerzo: Alto
   - Tiempo estimado: 5-7 días

### Prioridad Media

7. **Implementar logging**
   - Para debugging y auditoría
   - Usar `error_log()` o plugin de logging

8. **Crear archivo de configuración**
   - Centralizar configuraciones
   - Evitar hardcoding

9. **Mejorar manejo de errores**
   - Try-catch en operaciones críticas
   - Mensajes user-friendly

### Prioridad Baja

10. **Migrar a sistema i18n estándar**
    - Abandonar qTranslate style
    - Usar `__()` y archivos .po/.mo

11. **Optimizar consultas SQL**
    - Agregar índices
    - Usar caching cuando sea posible

12. **Responsive design audit**
    - Verificar que formularios funcionen en móviles

---

## 📝 Checklist de Instalación

Para instalar correctamente este plugin:

- [ ] Subir carpeta completa a `/wp-content/plugins/`
- [ ] Activar plugin desde WordPress admin
- [ ] Crear páginas requeridas con slugs correctos:
  - [ ] `registro-evento`
  - [ ] `registro-evento-recibo`
  - [ ] `listado-de-participantes`
  - [ ] `registro-edicion`
- [ ] Insertar shortcodes en páginas:
  - [ ] `[are_planesasuncion2026]` en página de planes
  - [ ] `[arc_config_eventos]` en página de admin
- [ ] Configurar metadatos en `evento_meta`:
  - [ ] `url` = `/asuncion2026/`
  - [ ] `name_es` = Nombre del evento
  - [ ] `name_en` = Event name
- [ ] Verificar tablas de BD existen:
  - [ ] `evento_orden`
  - [ ] `evento_meta`
  - [ ] `evento_orden_concepto`
- [ ] Configurar permisos de usuarios:
  - [ ] Crear rol "tesoreria"
  - [ ] Crear rol "secretaria"
- [ ] Probar flujo completo de registro
- [ ] Verificar generación de facturas/certificados

---

## 🎯 Conclusión

### Resumen Ejecutivo

El plugin **ASIPI Registro Eventos Asunción 2026** es un sistema robusto y completo para gestionar registros de eventos. Tiene una arquitectura modular bien pensada y múltiples funcionalidades avanzadas.

### Calificación General

| Aspecto | Calificación | Notas |
|---------|--------------|-------|
| **Funcionalidad** | ⭐⭐⭐⭐⭐ | Sistema completo y funcional |
| **Arquitectura** | ⭐⭐⭐⭐ | Bien modularizado |
| **Seguridad** | ⭐⭐ | Requiere mejoras críticas |
| **Código** | ⭐⭐⭐ | Funcional pero mejorable |
| **Documentación** | ⭐⭐ | Insuficiente en código |
| **Mantenibilidad** | ⭐⭐⭐ | Aceptable con mejoras |

### Fortalezas Principales

1. ✅ Sistema completo de registro multi-paso
2. ✅ Gestión de múltiples tipos de usuarios
3. ✅ Panel de administración para tesorería
4. ✅ Generación de facturas y certificados
5. ✅ Integración con WordPress Multisite

### Áreas de Mejora Críticas

1. ⚠️ Seguridad: Sanitización y prepared statements
2. ⚠️ Código comentado y archivos backup
3. ⚠️ Falta de documentación PHPDoc
4. ⚠️ Manejo de errores básico
5. ⚠️ Testing inexistente

### Recomendación Final

**El plugin es funcional y puede usarse en producción**, pero **requiere refactorización de seguridad urgente** antes de exponerlo a internet público. Se recomienda:

1. **Corto plazo (1-2 semanas):** Implementar sanitización y prepared statements
2. **Medio plazo (1-2 meses):** Agregar tests, documentación y nonces
3. **Largo plazo (3-6 meses):** Refactorización completa con mejores prácticas

---

## 📚 Recursos Adicionales

### Documentación de Referencia

- **WordPress Plugin Handbook:** https://developer.wordpress.org/plugins/
- **WordPress Security:** https://developer.wordpress.org/plugins/security/
- **$wpdb Class Reference:** https://developer.wordpress.org/reference/classes/wpdb/
- **Data Validation:** https://developer.wordpress.org/plugins/security/data-validation/

### Herramientas Recomendadas

- **WP-CLI:** Para operaciones de línea de comandos
- **Query Monitor:** Plugin para debugging
- **PHP_CodeSniffer:** Con WordPress Coding Standards
- **PHPUnit:** Para testing unitario

---

**Análisis realizado por:** Claude Sonnet 4.5
**Fecha:** 2026-01-28
**Versión del análisis:** 1.0
**Próxima revisión recomendada:** Después de implementar mejoras de seguridad
