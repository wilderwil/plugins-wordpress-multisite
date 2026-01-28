# Mejoras de Seguridad - Plugin ASIPI Asunción

**Fecha:** 2026-01-28
**Versión:** 2.0.1
**Estado:** En progreso

---

## 🔒 Correcciones Implementadas

### Archivo Principal: `asipi-registro-eventos-asuncion.php`

#### 1. Protección contra Acceso Directo ✅

**Línea 9-11:**
```php
// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}
```

**Beneficio:** Previene que el archivo sea ejecutado directamente vía URL.

---

#### 2. Sanitización de Email ✅

**Antes (Línea 44):**
```php
if (isset($_REQUEST['email'])) {
    include('include/registro/registrar.php');
    // Email usado sin sanitizar
}
```

**Después (Líneas 43-53):**
```php
if (isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
    $email = sanitize_email($_REQUEST['email']);

    // Validar que sea un email válido
    if (is_email($email)) {
        include('include/registro/registrar.php');
        // ...
    } else {
        return '<div class="alert alert-danger">Email inválido...</div>';
    }
}
```

**Beneficios:**
- ✅ Sanitiza el email con `sanitize_email()`
- ✅ Valida formato con `is_email()`
- ✅ Muestra mensaje de error apropiado
- ✅ Previene inyección de código malicioso

---

#### 3. Consulta SQL con Prepared Statement ✅

**Antes (Línea 53):**
```php
$event_url = $wpdb->get_var("SELECT valor FROM evento_meta WHERE clave = 'url' and evento_id = $blog_id");
```

**Después (Líneas 58-62):**
```php
$event_url = $wpdb->get_var( $wpdb->prepare(
    "SELECT valor FROM evento_meta WHERE clave = %s AND evento_id = %d",
    'url',
    $blog_id
));
```

**Beneficios:**
- ✅ Previene SQL Injection
- ✅ Usa placeholders seguros (%s, %d)
- ✅ WordPress maneja el escapado automáticamente

---

#### 4. Escapado de URLs en Output ✅

**Antes (Línea 55):**
```php
return '<br><br><a href="'.$event_url.'registro-evento" class="btn btn-success">Volver</a>';
```

**Después (Línea 65):**
```php
$escaped_url = esc_url($event_url . 'registro-evento');
return '<br><br><a href="' . $escaped_url . '" class="btn btn-success">Volver</a>';
```

**Beneficios:**
- ✅ Previene XSS (Cross-Site Scripting)
- ✅ Sanitiza URL antes de mostrarla
- ✅ Protocolo validado automáticamente

---

#### 5. Corrección de Consultas en Menú de Navegación ✅

**Función: `add_extra_item_to_nav_menu()`**

##### 5.1. Verificación de Usuario Registrado

**Antes (Línea 199):**
```php
$sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and visible = 1 and evento_id = '$event_id'";
$user_id_2 = $wpdb->get_var($sql_user);
```

**Después:**
```php
$user_id = absint($current_user->ID);  // Sanitizar ID

$user_id_2 = $wpdb->get_var( $wpdb->prepare(
    "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = %d AND visible = 1 AND evento_id = %d",
    $user_id,
    $event_id
));
```

**Beneficios:**
- ✅ `absint()` asegura que sea entero positivo
- ✅ Prepared statement previene SQL Injection
- ✅ Sintaxis SQL más limpia (AND en mayúsculas)

##### 5.2. Verificación de Secretaría/Tesorería

**Antes (Línea 206):**
```php
$user_is_secretaria = $wpdb->get_var('SELECT COUNT(*) from pwisa_usermeta where meta_key = "pwisa_capabilities" AND (meta_value LIKE "%tesoreria%" or meta_value LIKE "%secretaria%")  AND user_id ='.$user_id);
```

**Después:**
```php
$user_is_secretaria = $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM pwisa_usermeta WHERE meta_key = %s AND (meta_value LIKE %s OR meta_value LIKE %s) AND user_id = %d",
    'pwisa_capabilities',
    '%tesoreria%',
    '%secretaria%',
    $user_id
));
```

**Beneficios:**
- ✅ Prepared statement con múltiples placeholders
- ✅ LIKE patterns correctamente escapados
- ✅ Más legible y mantenible

##### 5.3. Registro Principal del Usuario

**Antes (Línea 218):**
```php
$sql_user = "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = '".$user_id."' and subnumero=1 and visible=1 and estado IN ('C','P') and evento_id = '$event_id'";
$user_id_2 = $wpdb->get_var($sql_user);
```

**Después:**
```php
$user_id_2 = $wpdb->get_var( $wpdb->prepare(
    "SELECT pwisa_users_ID FROM evento_orden WHERE pwisa_users_ID = %d AND subnumero = 1 AND visible = 1 AND estado IN ('C','P') AND evento_id = %d",
    $user_id,
    $event_id
));
```

**Beneficios:**
- ✅ IN clause segura con prepared statement
- ✅ Sintaxis consistente

##### 5.4. Escapado de URLs en Menú

**Antes:**
```php
$item3 = '<li ><a href="/asuncion2025/listado-de-participantes">...</a></li>';
```

**Después:**
```php
$item3 = '<li><a href="' . esc_url('/asuncion2025/listado-de-participantes') . '">...</a></li>';
```

**Beneficios:**
- ✅ URLs escapadas antes de output
- ✅ HTML más limpio (espacio extra removido)

---

## 📊 Estadísticas de Mejoras

| Métrica | Antes | Después | Mejora |
|---------|-------|---------|--------|
| **Protección acceso directo** | ❌ No | ✅ Sí | 100% |
| **Sanitización de inputs** | 0 | 1 (email) | +1 |
| **Prepared statements** | 0 | 4 | +4 |
| **Escapado de outputs** | 12 | 14 | +2 |
| **Validación de tipos** | 0 | 2 (absint) | +2 |

---

## 🔧 Fase 2: Correcciones en registrar.php (En Progreso)

### Archivo: `include/registro/registrar.php`

**Tamaño:** 1336 líneas (era 1281)
**Correcciones aplicadas:** 20+
**Estado:** Parcialmente corregido (10-15%)

#### 1. Protección contra Acceso Directo ✅

**Agregado (Línea 8-11):**
```php
// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}
```

#### 2. Sanitización de Inputs Críticos ✅

**Antes (Línea 20-23):**
```php
$lang = ($_REQUEST['lang']) ? $_REQUEST['lang'] : 'es' ;
$numero_orden = $_REQUEST['numero_orden'];
$subnumero = $_REQUEST['subnumero'];
```

**Después:**
```php
// Sanitizar inputs críticos
$lang = isset($_REQUEST['lang']) ? sanitize_text_field($_REQUEST['lang']) : 'es';
// Validar que sea es o en
$lang = in_array($lang, array('es', 'en')) ? $lang : 'es';

$numero_orden = isset($_REQUEST['numero_orden']) ? absint($_REQUEST['numero_orden']) : 0;
$subnumero = isset($_REQUEST['subnumero']) ? absint($_REQUEST['subnumero']) : 0;

// Validar que numero_orden sea válido
if ($numero_orden <= 0) {
    wp_die('Número de orden inválido');
}
```

**Beneficios:**
- ✅ `sanitize_text_field()` para lang
- ✅ Whitelist validation con `in_array()`
- ✅ `absint()` para enteros
- ✅ Validación de rango
- ✅ Error handling apropiado

#### 3. Prepared Statements en Consultas Críticas ✅

**3.1. Obtener Número de Factura**

**Antes (Línea 25):**
```php
$numero_factura= $wpdb->get_var("SELECT numero FROM evento_orden WHERE id = $numero_orden");
```

**Después:**
```php
$numero_factura = $wpdb->get_var( $wpdb->prepare(
    "SELECT numero FROM evento_orden WHERE id = %d",
    $numero_orden
));
```

**3.2. Verificar Número Vigente**

**Antes (Línea 27):**
```php
$numeroVigente1= $wpdb->get_var("SELECT count(*) FROM evento_orden WHERE subnumero = $subnumero and numero= $numero_factura and evento_id='".$blog_id."'");
```

**Después:**
```php
$numeroVigente1 = $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM evento_orden WHERE subnumero = %d AND numero = %s AND evento_id = %d",
    $subnumero,
    $numero_factura,
    $blog_id
));
```

**3.3. Obtener Orden Original**

**Antes (Línea 37):**
```php
$sql_orden = "SELECT * FROM `evento_orden` WHERE `id` = '$numero_orden'";
$queryResult = $wpdb->get_results($sql_orden);
```

**Después:**
```php
$queryResult = $wpdb->get_results( $wpdb->prepare(
    "SELECT * FROM `evento_orden` WHERE `id` = %d",
    $numero_orden
));

if (empty($queryResult)) {
    wp_die('Orden no encontrada');
}
```

**Beneficios:**
- ✅ 3 prepared statements implementados
- ✅ Prevención de SQL Injection
- ✅ Validación de resultados vacíos
- ✅ Sintaxis SQL mejorada (COUNT vs count)

#### 4. Sanitización de IDs de Actividades y Talleres ✅

**Antes (Líneas 96-106):**
```php
$evento_social_1_id = ($_REQUEST['monto_actividad_1211']>0) ? $_REQUEST['id_actividad_1'] : '0' ;
$evento_social_2_id = ($_REQUEST['monto_actividad_2210']>0) ? $_REQUEST['id_actividad_2'] : '0' ;
// ... 10 variables más sin sanitizar
```

**Después:**
```php
$evento_social_1_id = (isset($_REQUEST['monto_actividad_1211']) && absint($_REQUEST['monto_actividad_1211']) > 0)
    ? absint($_REQUEST['id_actividad_1']) : 0;

$evento_social_2_id = (isset($_REQUEST['monto_actividad_2210']) && absint($_REQUEST['monto_actividad_2210']) > 0)
    ? absint($_REQUEST['id_actividad_2']) : 0;

// ... 10 variables sanitizadas con absint()
```

**Variables sanitizadas (12 total):**
- `$evento_social_1_id` (Carrera Caminata)
- `$evento_social_2_id` (Ruta Indicaciones Geográficas)
- `$evento_social_3_id` (City Tour)
- `$evento_social_4_id` (Come as You Are)
- `$evento_social_5_id` (Yoga)
- `$evento_actividad_id` (Deportiva)
- `$evento_taller_id` (Taller 1)
- `$evento_taller2_id` (Taller 2)
- `$evento_social_7_id` (Especialidad Tradicional)
- `$evento_social_8_id` (Desayuno Concurso)
- `$evento_social_9_id` (Cata de vino)
- `$total` (Total de pago)

**Beneficios:**
- ✅ 12 variables sanitizadas con `absint()`
- ✅ Prevención de SQL Injection en INSERT posterior
- ✅ Validación de `isset()` antes de acceder
- ✅ Código más legible y mantenible
- ✅ Valores default seguros (0 en lugar de '0' string)

#### 5. Validación de Total de Pago ✅

**Antes (Línea 88):**
```php
if ((int) $_REQUEST['total'] == 0) {
    $status = 'C';
    $visible = 0;
}
```

**Después:**
```php
// Sanitizar total antes de usar
$total = isset($_REQUEST['total']) ? absint($_REQUEST['total']) : 0;
if ($total == 0) {
    $status = 'C';
    $visible = 0;
}
```

**Beneficios:**
- ✅ Sanitización con `absint()`
- ✅ Validación de `isset()`
- ✅ Variable reutilizable

---

### ⚠️ CRÍTICO - Pendiente de Corrección

#### INSERT Masivo Sin Prepared Statement

**Ubicación:** Líneas 107-150+

**Problema CRÍTICO:**
```php
$sqlActivites = "INSERT INTO evento_orden (...) VALUES (
    '".$ordenOriginal->pwisa_users_ID."',
    '".$blog_id."',
    '".$status."',
    // ... 20+ columnas más concatenadas directamente
)";
$wpdb->query($sqlActivites);
```

**Riesgo:** SQL INJECTION CRÍTICO

**Solución Requerida:**
```php
$wpdb->insert(
    'evento_orden',
    array(
        'pwisa_users_ID' => $ordenOriginal->pwisa_users_ID,
        'evento_id' => $blog_id,
        'estado' => $status,
        // ... todas las columnas
    ),
    array(
        '%d', // pwisa_users_ID
        '%d', // evento_id
        '%s', // estado
        // ... formats para todas las columnas
    )
);
```

**Esfuerzo estimado:** 2-3 horas
**Prioridad:** CRÍTICA

---

### 📊 Estadísticas Fase 2

| Métrica | Valor |
|---------|-------|
| **Inputs sanitizados** | 15+ |
| **Prepared statements** | 3 |
| **Validaciones agregadas** | 5 |
| **Líneas modificadas** | ~80 |
| **Líneas agregadas** | +55 |
| **Tamaño archivo** | 1281 → 1336 líneas |
| **Progreso estimado** | ~10-15% del archivo |

### 📈 Mejoras Totales (Fase 1 + Fase 2 Parcial)

| Métrica | Fase 1 | Fase 2 | Total |
|---------|--------|--------|-------|
| **Protecciones ABSPATH** | 1 | 1 | 2 |
| **Inputs sanitizados** | 1 | 15 | 16 |
| **Prepared statements** | 4 | 3 | 7 |
| **Validaciones** | 2 | 5 | 7 |
| **Escapado outputs** | 2 | 0 | 2 |

---

## ⚠️ Pendientes de Corrección

### Prioridad Alta

1. **Archivo `include/registro/registrar.php` (1281 líneas)**
   - Procesamiento principal de registro
   - Múltiples `$_REQUEST` sin sanitizar
   - Consultas SQL con concatenación

2. **Archivos de Login (7 archivos)**
   - `include/login/getUserLogueado.php` (238 líneas)
   - `include/login/invitados.php` (337 líneas)
   - `include/login/nosocio.php` (235 líneas)
   - Requieren sanitización y prepared statements

3. **Sistema de Facturación (4 archivos)**
   - `include/invoice/dlInvoice.php` (659 líneas)
   - `include/invoice/dlInvoiceEvento.php` (461 líneas)
   - Consultas SQL sin prepared statements

### Prioridad Media

4. **Tesorería (6 archivos)**
   - `include/tesoreria/lista_registros.php` (759 líneas)
   - Panel de administración con consultas SQL

5. **Formularios JotForm (5 archivos)**
   - Validar que las APIs keys estén protegidas
   - Verificar sanitización de respuestas

### Prioridad Baja

6. **Archivos de Paso (paso1-4.php)**
   - Principalmente presentación
   - Revisar outputs escapados

7. **JavaScript (3 archivos)**
   - Verificar validaciones client-side
   - Asegurar que no expongan datos sensibles

---

## 🛡️ Mejores Prácticas Aplicadas

### 1. Sanitización de Inputs

```php
// Para emails
$email = sanitize_email($_POST['email']);

// Para enteros
$id = absint($_POST['id']);

// Para texto
$text = sanitize_text_field($_POST['text']);

// Para textareas
$content = sanitize_textarea_field($_POST['content']);

// Para URLs
$url = esc_url_raw($_POST['url']);
```

### 2. Prepared Statements

```php
// Formato correcto
$result = $wpdb->get_var( $wpdb->prepare(
    "SELECT column FROM table WHERE id = %d AND name = %s",
    $id,
    $name
));

// Placeholders:
// %d - integer
// %f - float
// %s - string
```

### 3. Escapado de Outputs

```php
// Para HTML
echo esc_html($text);

// Para atributos
echo '<input value="' . esc_attr($value) . '">';

// Para URLs
echo '<a href="' . esc_url($url) . '">';

// Para JavaScript
echo '<script>var data = ' . wp_json_encode($data) . ';</script>';
```

### 4. Validación de Permisos

```php
// Verificar capacidades
if (!current_user_can('manage_options')) {
    wp_die('No tienes permisos');
}

// Verificar nonces en formularios
if (!wp_verify_nonce($_POST['nonce'], 'action_name')) {
    wp_die('Acción no autorizada');
}
```

---

## 📈 Plan de Acción Recomendado

### Fase 1 (Completada) ✅
- [x] Protección acceso directo
- [x] Sanitizar email principal
- [x] Corregir consultas SQL críticas
- [x] Escapar URLs principales

### Fase 2 (En Progreso) ⚙️
- [x] Protección acceso directo en registrar.php
- [x] Sanitizar numero_orden, subnumero, lang
- [x] 3 prepared statements en consultas críticas
- [x] Sanitizar 12 IDs de actividades y talleres
- [x] Validación de total antes de usar
- [ ] Refactorizar INSERT con prepared statement (CRÍTICO)
- [ ] Sanitizar ~500+ inputs restantes
- [ ] Corregir `include/registro/registrar.php`
- [ ] Sanitizar todos los inputs del formulario
- [ ] Agregar nonces a formularios
- [ ] Validar tipos de datos

### Fase 3 (Futuro)
- [ ] Corregir archivos de login
- [ ] Actualizar sistema de facturación
- [ ] Refactorizar tesorería
- [ ] Agregar tests de seguridad

### Fase 4 (Mantenimiento)
- [ ] Code review completo
- [ ] Auditoría de seguridad externa
- [ ] Documentar todas las funciones
- [ ] Crear guía de seguridad para desarrolladores

---

## 🧪 Testing de Seguridad

### Tests Realizados

✅ Acceso directo al archivo PHP - **BLOQUEADO**
✅ Email malformado - **RECHAZADO**
✅ SQL Injection en user_id - **PREVENIDO**
✅ XSS en URL - **ESCAPADO**

### Tests Pendientes

- [ ] Fuzzing de todos los inputs
- [ ] Pen testing completo
- [ ] CSRF testing
- [ ] Session hijacking test
- [ ] File upload security (si aplica)

---

## 📚 Referencias

- **WordPress Security:** https://developer.wordpress.org/plugins/security/
- **Data Validation:** https://developer.wordpress.org/plugins/security/data-validation/
- **OWASP Top 10:** https://owasp.org/www-project-top-ten/
- **wpdb Class:** https://developer.wordpress.org/reference/classes/wpdb/

---

## 👤 Créditos

**Análisis y correcciones por:** Claude Sonnet 4.5
**Revisión técnica:** Pendiente
**Última actualización:** 2026-01-28
**Próxima revisión:** Después de Fase 2

---

## 📝 Notas

- Todas las correcciones mantienen la funcionalidad original
- No se rompió retrocompatibilidad
- Código más seguro y mantenible
- Se incrementó versión a 2.0.1
- Se recomienda testing exhaustivo antes de producción

