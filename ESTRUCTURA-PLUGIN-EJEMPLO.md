# Estructura de Plugin Personalizado para WordPress

## Estructura Básica Recomendada

```
wp-content/plugins/mi-plugin/
├── mi-plugin.php              # Archivo principal del plugin
├── README.md                  # Documentación del plugin
├── uninstall.php             # Script de desinstalación (opcional)
├── assets/
│   ├── css/
│   │   ├── admin.css         # Estilos del admin
│   │   └── public.css        # Estilos del frontend
│   ├── js/
│   │   ├── admin.js          # JavaScript del admin
│   │   └── public.js         # JavaScript del frontend
│   └── images/
│       └── icon.png
├── includes/
│   ├── class-activator.php   # Lógica de activación
│   ├── class-deactivator.php # Lógica de desactivación
│   └── class-loader.php      # Cargador de hooks
├── admin/
│   ├── class-admin.php       # Funcionalidad del admin
│   ├── partials/             # Templates del admin
│   └── settings.php          # Página de configuración
└── public/
    ├── class-public.php      # Funcionalidad del frontend
    └── partials/             # Templates del frontend
```

## Ejemplo de Archivo Principal (mi-plugin.php)

```php
<?php
/**
 * Plugin Name: Mi Plugin Personalizado
 * Plugin URI: https://tudominio.com/mi-plugin
 * Description: Descripción de lo que hace tu plugin
 * Version: 1.0.0
 * Author: Tu Nombre
 * Author URI: https://tudominio.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mi-plugin
 * Domain Path: /languages
 * Network: true  // Para Multisitio
 */

// Si se accede directamente, salir
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes
define('MI_PLUGIN_VERSION', '1.0.0');
define('MI_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MI_PLUGIN_URL', plugin_dir_url(__FILE__));

// Hook de activación
register_activation_hook(__FILE__, 'mi_plugin_activar');
function mi_plugin_activar() {
    // Código de activación
    flush_rewrite_rules();
}

// Hook de desactivación
register_deactivation_hook(__FILE__, 'mi_plugin_desactivar');
function mi_plugin_desactivar() {
    // Código de desactivación
    flush_rewrite_rules();
}

// Cargar plugin
require_once MI_PLUGIN_PATH . 'includes/class-loader.php';

// Inicializar
function mi_plugin_init() {
    $plugin = new Mi_Plugin_Loader();
    $plugin->run();
}
add_action('plugins_loaded', 'mi_plugin_init');
```

## Ejemplo de Funcionalidad Multisitio

```php
<?php
// Verificar si es multisitio
if (!is_multisite()) {
    return;
}

// Hook específico de multisitio
add_action('network_admin_menu', 'mi_plugin_network_menu');
function mi_plugin_network_menu() {
    add_menu_page(
        'Mi Plugin',
        'Mi Plugin',
        'manage_network_options',
        'mi-plugin',
        'mi_plugin_network_page'
    );
}

// Obtener todos los sitios de la red
function mi_plugin_obtener_sitios() {
    return get_sites(array(
        'number' => 0, // Sin límite
        'orderby' => 'domain'
    ));
}

// Aplicar configuración a todos los sitios
function mi_plugin_aplicar_a_todos_los_sitios($callback) {
    $sitios = mi_plugin_obtener_sitios();

    foreach ($sitios as $sitio) {
        switch_to_blog($sitio->blog_id);
        call_user_func($callback);
        restore_current_blog();
    }
}

// Ejemplo de uso
add_action('admin_init', 'mi_plugin_configurar_red');
function mi_plugin_configurar_red() {
    if (is_network_admin() && isset($_POST['aplicar_a_todos'])) {
        mi_plugin_aplicar_a_todos_los_sitios(function() {
            update_option('mi_plugin_opcion', $_POST['valor']);
        });
    }
}
```

## Buenas Prácticas

### 1. Usar Prefijos

```php
// Malo ✗
function guardar_datos() {}
class Usuario {}

// Bueno ✓
function mi_plugin_guardar_datos() {}
class Mi_Plugin_Usuario {}
```

### 2. Seguridad

```php
// Validar nonces
if (!wp_verify_nonce($_POST['_wpnonce'], 'mi_plugin_accion')) {
    wp_die('Acceso no autorizado');
}

// Sanitizar entrada
$valor = sanitize_text_field($_POST['campo']);

// Escapar salida
echo esc_html($valor);
echo esc_url($url);
echo esc_attr($atributo);
```

### 3. Enqueue de Scripts y Estilos

```php
add_action('wp_enqueue_scripts', 'mi_plugin_enqueue_scripts');
function mi_plugin_enqueue_scripts() {
    wp_enqueue_style(
        'mi-plugin-css',
        MI_PLUGIN_URL . 'assets/css/public.css',
        array(),
        MI_PLUGIN_VERSION
    );

    wp_enqueue_script(
        'mi-plugin-js',
        MI_PLUGIN_URL . 'assets/js/public.js',
        array('jquery'),
        MI_PLUGIN_VERSION,
        true
    );
}
```

### 4. AJAX para Multisitio

```php
// En el archivo principal
add_action('wp_ajax_mi_accion', 'mi_plugin_ajax_handler');
add_action('wp_ajax_nopriv_mi_accion', 'mi_plugin_ajax_handler');

function mi_plugin_ajax_handler() {
    check_ajax_referer('mi_plugin_nonce');

    // Lógica aquí

    wp_send_json_success(array(
        'mensaje' => 'Éxito'
    ));
}

// En JavaScript
jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    data: {
        action: 'mi_accion',
        _ajax_nonce: mi_plugin_vars.nonce
    },
    success: function(response) {
        console.log(response);
    }
});
```

## Plugin Mínimo Funcional

```php
<?php
/**
 * Plugin Name: Plugin Mínimo
 * Version: 1.0.0
 * Network: true
 */

if (!defined('ABSPATH')) exit;

// Agregar menú en admin
add_action('admin_menu', 'plugin_minimo_menu');
function plugin_minimo_menu() {
    add_menu_page(
        'Plugin Mínimo',
        'Plugin Mínimo',
        'manage_options',
        'plugin-minimo',
        'plugin_minimo_pagina',
        'dashicons-admin-generic'
    );
}

// Página de admin
function plugin_minimo_pagina() {
    ?>
    <div class="wrap">
        <h1>Plugin Mínimo</h1>
        <p>Tu plugin funciona correctamente.</p>
    </div>
    <?php
}

// Shortcode
add_shortcode('saludo', 'plugin_minimo_shortcode');
function plugin_minimo_shortcode($atts) {
    $atts = shortcode_atts(array(
        'nombre' => 'Mundo'
    ), $atts);

    return '<p>Hola ' . esc_html($atts['nombre']) . '!</p>';
}
```

Uso del shortcode: `[saludo nombre="Juan"]`

## Versionado Semántico

```
v1.0.0 → Primera versión estable
v1.0.1 → Parche (bug fixes)
v1.1.0 → Minor (nueva funcionalidad, compatible)
v2.0.0 → Major (cambios que rompen compatibilidad)
```

## Testing

```php
// Crear función de debug
function mi_plugin_debug($data, $label = '') {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('MI_PLUGIN ' . $label . ': ' . print_r($data, true));
    }
}

// Uso
mi_plugin_debug($variable, 'Verificar variable');
```

## Resources

- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- [Plugin Boilerplate Generator](https://wppb.me/)
