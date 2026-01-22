#!/bin/bash

# ============================================
# CONFIGURACIÓN DE SERVIDORES
# ============================================
# IMPORTANTE: Copia este archivo a deploy-config.local.sh
# y configura tus credenciales ahí (ese archivo está en .gitignore)

# STAGING
STAGING_USER="tu_usuario_ssh"
STAGING_HOST="staging.tudominio.com"
STAGING_PATH="/home/usuario/public_html/wp-content/plugins"
STAGING_PORT="22"

# PRODUCCIÓN
PROD_USER="tu_usuario_ssh"
PROD_HOST="tudominio.com"
PROD_PATH="/home/usuario/public_html/wp-content/plugins"
PROD_PORT="22"

# PLUGINS A DEPLOYAR (separados por espacio)
# Ejemplo: CUSTOM_PLUGINS="mi-plugin otro-plugin"
CUSTOM_PLUGINS="mi-plugin-personalizado"

# OPCIONES DE BACKUP
BACKUP_ENABLED=true
BACKUP_KEEP_DAYS=7

# OPCIONES DE RSYNC
RSYNC_OPTIONS="-avz --delete --exclude='.git' --exclude='node_modules' --exclude='.DS_Store'"

# NOTIFICACIONES (opcional - configurar si usas Slack, etc)
SLACK_WEBHOOK=""
