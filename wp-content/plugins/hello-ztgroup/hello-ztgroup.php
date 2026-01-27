<?php
/**
 * Plugin Name: Hello ZTGroup
 * Plugin URI: https://github.com/wilderwil/plugins-wordpress-multisite
 * Description: Plugin de ejemplo para demostrar el flujo de deployment con Git
 * Version: 1.0.0
 * Author: ZTGroup
 * Author URI: https://github.com/wilderwil
 * License: MIT
 * Text Domain: hello-ztgroup
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Agregar mensaje en el dashboard de WordPress
 */
function hztg_admin_notice() {
    $screen = get_current_screen();

    // Solo mostrar en el dashboard principal
    if ($screen->id === 'dashboard') {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong>🚀 Hello ZTGroup!</strong>
                Este es un plugin de ejemplo para demostrar el sistema de deployment.
                <br>
                <em>Versión: 1.0.0 | Ambiente: <?php echo wp_get_environment_type(); ?></em>
            </p>
        </div>
        <?php
    }
}
add_action('admin_notices', 'hztg_admin_notice');

/**
 * Agregar menú en el admin
 */
function hztg_admin_menu() {
    add_menu_page(
        'Hello ZTGroup',           // Page title
        'Hello ZTGroup',           // Menu title
        'manage_options',          // Capability
        'hello-ztgroup',           // Menu slug
        'hztg_admin_page',         // Callback function
        'dashicons-heart',         // Icon
        100                        // Position
    );
}
add_action('admin_menu', 'hztg_admin_menu');

/**
 * Página de administración del plugin
 */
function hztg_admin_page() {
    ?>
    <div class="wrap">
        <h1>🎉 Hello ZTGroup</h1>
        <div class="card">
            <h2>Plugin de Ejemplo</h2>
            <p>Este plugin fue creado para demostrar el flujo completo de desarrollo:</p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><strong>Local:</strong> Desarrollo y pruebas iniciales</li>
                <li><strong>GitHub:</strong> Control de versiones y colaboración</li>
                <li><strong>Staging:</strong> Ambiente de pruebas pre-producción</li>
                <li><strong>Producción:</strong> Sitio en vivo</li>
            </ul>

            <h3>Información del Sistema</h3>
            <table class="widefat" style="max-width: 600px;">
                <tr>
                    <td><strong>Versión Plugin:</strong></td>
                    <td>1.0.0</td>
                </tr>
                <tr>
                    <td><strong>Ambiente:</strong></td>
                    <td><?php echo wp_get_environment_type(); ?></td>
                </tr>
                <tr>
                    <td><strong>WordPress:</strong></td>
                    <td><?php echo get_bloginfo('version'); ?></td>
                </tr>
                <tr>
                    <td><strong>PHP:</strong></td>
                    <td><?php echo PHP_VERSION; ?></td>
                </tr>
            </table>

            <p style="margin-top: 20px;">
                <a href="https://github.com/wilderwil/plugins-wordpress-multisite" target="_blank" class="button button-primary">
                    Ver en GitHub
                </a>
            </p>
        </div>
    </div>
    <style>
        .card {
            max-width: 800px;
            padding: 20px;
        }
    </style>
    <?php
}

/**
 * Activación del plugin
 */
function hztg_activation() {
    // Guardar fecha de activación
    update_option('hztg_activated_date', current_time('mysql'));

    // Log de activación
    if (function_exists('error_log')) {
        error_log('Hello ZTGroup plugin activated at ' . current_time('mysql'));
    }
}
register_activation_hook(__FILE__, 'hztg_activation');

/**
 * Desactivación del plugin
 */
function hztg_deactivation() {
    // Log de desactivación
    if (function_exists('error_log')) {
        error_log('Hello ZTGroup plugin deactivated at ' . current_time('mysql'));
    }
}
register_deactivation_hook(__FILE__, 'hztg_deactivation');
